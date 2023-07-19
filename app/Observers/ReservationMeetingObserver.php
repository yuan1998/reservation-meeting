<?php

namespace App\Observers;

use App\Models\ReservationMeeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ReservationMeetingObserver
{

    public function saving(ReservationMeeting $meeting) {
        $start = $meeting->getAttribute('start');
        $id = $meeting->getAttribute('room_id');
        $date = $meeting->getAttribute('date');
        $end = $meeting->getAttribute('end');
        if ($start && $id && $date && $end) {
            $earliest = ReservationMeeting::getDateCacheTime($id, $date);
            $latest = ReservationMeeting::getDateCacheTime($id, $date, 'latest');
            $end1 = Carbon::parse("$date $end");
            $start1 = Carbon::parse("$date $start");

            if (!$latest || $end1->gt($latest)) {
                Cache::put("$id-$date-latest" , "$date $end" ,$end1->addDays(15));
            }

            if (!$earliest || $start1->lt($earliest)) {
                Cache::put("$id-$date-earliest" , "$date $start" ,$start1->addDays(15));
            }
        }
    }

}
