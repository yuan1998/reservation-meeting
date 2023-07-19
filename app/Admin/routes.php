<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/setting', 'HomeController@setting');
    $router->resource('customer_users', 'UserController');
    $router->resource('meeting_rooms', 'MeetingRoomController');
    $router->resource('reservation_meetings', 'ReservationMeetingController');

});
