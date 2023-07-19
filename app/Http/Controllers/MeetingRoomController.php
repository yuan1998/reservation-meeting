<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use App\Models\ReservationMeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingRoomController extends Controller
{

    public function index()
    {
        $data = MeetingRoom::query()->where('enable', 1)->orderBy('order')->get();

        return response()->json([
            'code' => self::HTTP_OK,
            'data' => $data,
            'msg' => 'OK'
        ]);
    }

    public function detail($id, Request $request)
    {
        $room = MeetingRoom::find($id);
        if (!$room)
            return response()->json([
                'code' => self::HTTP_REQUEST_ERROR,
                'msg' => '无法查到该会议室'
            ]);
        return response()->json([
            'code' => self::HTTP_OK,
            'data' => $room->toArray(),
            'msg' => 'OK'
        ]);
    }

}
