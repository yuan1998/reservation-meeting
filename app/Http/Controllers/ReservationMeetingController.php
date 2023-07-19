<?php

namespace App\Http\Controllers;

use App\Models\ReservationMeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReservationMeetingController extends Controller
{

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->get('date');
        $roomId = $request->get('room_id');
        $userId = $request->get('user_id');
        $query = ReservationMeeting::query()
            ->with(['room'])
            ->orderBy('status')
            ->orderBy('date', 'desc')
            ->orderBy('start');

        if ($date) {
            $query->whereDate('date', $date);
        }
        if ($userId) {
            $query->where('user_id', $userId)
                ->where('status', '<>', 0);
        }
        if ($roomId)
            $query->where('room_id', $roomId);

        $data = $query->paginate(20)->through(function ($item) {
            if ($item['close_image'])
                $item['close_image'] = Storage::disk('public')->url($item['close_image']);
            return $item;
        });

        return response()
            ->json([
                'code' => self::HTTP_OK,
                'msg' => 'OK',
                'data' => $data
            ]);
    }

    public function saveImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image',
        ]);
        if ($validator->fails()) {
            return self::validateErrorResponse($validator);
        }

        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('meeting_images', $fileName, 'public');

        return self::okResponse([
            'path' => $path,
            'url' => Storage::disk('public')->url($path)
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:meeting_rooms,id',
            'date' => 'required|date',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'title' => 'required',
            'person_name' => 'required',
            'person_phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => self::HTTP_REQUEST_ERROR,
                'msg' => $validator->messages()->first(),
            ]);
        }

        $data = $validator->validated();
        if (!ReservationMeeting::checkCurrentDateIsValid($data['room_id'], $data['date'], $data['start'], $data['end']))
            return response()->json([
                'code' => self::HTTP_REQUEST_ERROR,
                'msg' => "所选择的时段不可预约或已被预约",
            ]);

        $data['meeting_remark'] = $request->get('meeting_remark');
        $user = $request->user();
        $data['user_id'] = $user->id;

        $model = ReservationMeeting::create($data);

        if (!$user->name || !$user->phone) {
            $user->name = $data['person_name'];
            $user->phone = $data['person_phone'];
            $user->save();
        }


        return response()
            ->json([
                'code' => self::HTTP_OK,
                'data' => $model->id,
                'msg' => 'OK',
            ]);
    }

    public function first(Request $request)
    {
        $id = $request->user()->id;
        $first = ReservationMeeting::query()
            ->with(['room'])
            ->where('user_id', $id)
            ->where('status', 1)
            ->orderBy('date', 'desc')
            ->orderBy('start')
            ->first();

        return self::okResponse($first);
    }

    public function canCreate(Request $request)
    {
        $id = $request->user()->id;
        $exists = ReservationMeeting::query()
            ->where('user_id', $id)
            ->where('status', 1)
            ->exists();

        return self::okResponse(!$exists);
    }

    public function endMeeting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:reservation_meetings,id',
            'close_image' => 'required',
        ]);
        if ($validator->fails()) {
            return self::validateErrorResponse($validator);
        }
        $data = $validator->validated();
        $data['status'] = 2;
        $data['close_remark'] = $request->get('close_remark');
        $r = ReservationMeeting::query()
            ->where('id', $data['id'])
            ->update($data);

        $date = $request->get('date');
        $roomId = $request->get('room_id');
        if ($date && $roomId) {
            ReservationMeeting::cleanCacheTime($roomId, $date);
        }

        return self::okResponse($r);

    }

    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:reservation_meetings,id',
        ]);
        if ($validator->fails()) {
            return self::validateErrorResponse($validator);
        }
        $r = ReservationMeeting::query()
            ->where('id', $request->get('id'))
            ->update([
                'status' => 3
            ]);


        $date = $request->get('date');
        $roomId = $request->get('room_id');
        if ($date && $roomId) {
            ReservationMeeting::cleanCacheTime($roomId, $date);
        }

        return self::okResponse($r);
    }

    public function detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:reservation_meetings,id',
        ]);
        if ($validator->fails()) {
            return self::validateErrorResponse($validator);
        }

        $data = $validator->validated();
        $list = ReservationMeeting::query()
            ->with(['room'])
            ->where('id', $data['id'])
            ->first();

        return response()
            ->json([
                'code' => self::HTTP_OK,
                'data' => $list,
                'msg' => "OK"
            ]);

    }
}
