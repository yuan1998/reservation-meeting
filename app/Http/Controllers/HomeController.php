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


}
