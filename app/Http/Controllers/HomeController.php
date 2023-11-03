<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use App\Models\ReservationMeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('welcome');

    }

    public function homeSetting()
    {
        return self::okResponse(collect(admin_setting())->only(["DISABLE_RESERVATION",
            "DEFAULT_REMARK"]));
    }
    public function sendCarNo(Request $request) {
        $hook = "https://oapi.dingtalk.com/robot/send?access_token=bbac4eb83a04687d2647ba6a89b6b4bab3c3134a5b7ece17c2ac9a994c59a2e2";
        $no = $request->get("car-no");

        ReservationMeeting::postToDingDingMessage($hook , "车牌号: $no\n\r请放行");
    }


}
