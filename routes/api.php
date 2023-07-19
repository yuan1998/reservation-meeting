<?php

use App\Http\Controllers\MeetingRoomController;
use App\Http\Controllers\ReservationMeetingController;
use App\Http\Controllers\WeChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/wechat/user', [WeChatController::class, 'indexUser']);
    Route::get('/reservation/can-create', [ReservationMeetingController::class, 'canCreate']);
    Route::get('/reservation/first', [ReservationMeetingController::class, 'first']);
    Route::post('/reservation', [ReservationMeetingController::class, 'store']);
    Route::post('/reservation/end', [ReservationMeetingController::class, 'endMeeting']);
});
Route::post('/reservation/end/image', [ReservationMeetingController::class, 'saveImage']);
Route::get('/reservation/detail' , [ReservationMeetingController::class, 'detail']);
Route::get('/reservation/detail' , [ReservationMeetingController::class, 'detail']);
Route::get('/reservation' , [ReservationMeetingController::class, 'index']);
Route::get('/rooms' , [MeetingRoomController::class, 'index']);
Route::get('/room/{id}' , [MeetingRoomController::class , 'detail']);

Route::any('/wechat/login', [WeChatController::class, 'login']);
Route::any('/wechat/phone', [WeChatController::class, 'decryptedPhone']);
