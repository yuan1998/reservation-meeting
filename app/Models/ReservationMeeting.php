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
        0 => '审核',
        1 => '预约成功',
        2 => '会议结束',
        3 => '会议取消',
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

    public function generateMarkdownMessageAndSend()
    {
        try {
            $room = $this->room;
            $name = $this->person_name;
            $date = substr($this->date, 0, 10);
            $start = $this->start;
            $end = $this->end;
            $msg = "## {$room->title}\n> 预约人: {$name}\n> 预约时间: {$date} {$start} ~ {$end}\n##### 喵~";
            return static::postReservationMessage([
                'msgtype' => 'markdown',
                'markdown' => [
                    'title' => $room->title,
                    "text" => $msg
                ]
            ]);
        } catch (\Exception $exception) {

        }
    }

    public static function postReservationMessage($data)
    {
        if (!admin_setting('ENABLE_POST')) return;
        if (!$hook = admin_setting('DINGDING_ROBOT')) return;

        if (is_string($data)) {
            $data = [
                'msgtype' => 'text',
                "text" => [
                    'content' => "$data 喵~"
                ]
            ];
        }

        $data_string = json_encode($data);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $hook);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
            // curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;

        } catch (\Exception $exception) {
            return;
        }
    }

    public static function getDateCacheTime($id, $date, $type = 'earliest')
    {
//        $key = "$id-$date-$type";
//        $time = Cache::get($key);
//        if (!$time) {
        $query = ReservationMeeting::query()
            ->where('room_id', $id)
            ->whereDate('date', $date)
            ->where('status', 1);
        if ($type === 'earliest') {
            $query->orderBy('start');
        } else {
            $query->orderBy('end', 'desc');
        }

        $item = $query->first();
        return $item ? $type === 'earliest' ? $item->start : $item->end : null;
//            if ($item) {
//        $time = ;
//                Cache::put($key, "$date $time", Carbon::parse($date)->addDays(15));
//            }
//        }

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
