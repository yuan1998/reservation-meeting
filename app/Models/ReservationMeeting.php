<?php

namespace App\Models;

use Carbon\Carbon;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ReservationMeeting extends Model
{
    use HasFactory, HasDateTimeFormatter;

    const STATUS_LIST = [
        0=> '审核',
        1=> '预约成功',
        2=> '会议结束',
    ];

    protected $fillable = [
        'title',
        'room_id',
        'user_id',
        'meeting_remark',
        'person_name',
        'person_phone',
        'start',
        'end',
        'date',
        'status',
        'close_remark',
        'close_image',
    ];


    public function room()
    {
        return $this->belongsTo(MeetingRoom::class, 'room_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function cleanCacheTime($id,$date) {
        $key = "$id-$date-earliest";
        $key1 = "$id-$date-latest";

        Cache::delete($key);
        Cache::delete($key1);
    }

    public static function getDateCacheTime($id, $date, $type = 'earliest')
    {
        $key = "$id-$date-$type";
        $time = Cache::get($key);
        if (!$time) {
            $query = ReservationMeeting::query()
                ->where('room_id', $id)
                ->whereDate('date', $date);
            if ($type === 'earliest') {
                $query->orderBy('start');
            } else {
                $query->orderBy('end', 'desc');
            }

            $item = $query->first();
            if ($item) {
                $time = $type === 'earliest' ? $item->start : $item->end;
                Cache::put($key, "$date $time", Carbon::parse($date)->addDays(15));
            }
        }

        return $time;
    }

    public static function checkCurrentDateIsValid($id, $date, $start, $end)
    {
        $earliest = self::getDateCacheTime($id, $date);
        $latest = self::getDateCacheTime($id, $date, 'latest');
        if (!$earliest && !$latest)
            return true;

        $start = Carbon::parse("$date $start");
        $end = Carbon::parse("$date $end");

        if ($end->lte($start))
            return false;

        if (($end->gt($earliest) && $start->lt($latest)) || ($start->eq($earliest) && $end->eq($latest)))
            return false;
        return true;
    }

}
