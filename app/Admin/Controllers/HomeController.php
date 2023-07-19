<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('Description...')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $user = Admin::user();

                    $params = [
                        'greeting' => $this->greetOfNowCn(),
                        'username' => $user->name,
                        'avatar' => $user->getAvatar(),
                    ];
                    $title = view('admin::dashboard.title', $params);
                    $column->row($title);
                });


            });
    }

    private function greetOfNowCn($date = null)
    {

            $r = $this->greetOfNow($date);
            $l = [
                1 => '早上',
                2 => '下午',
                3 => '晚上',
            ];
            return data_get($l, $r);
    }

    private function greetOfNow(mixed $date)
    {
        $date = $date ?: now();
        $hour = $date->format('H');
        if ($hour < 12) {
            return 1;
        }
        if ($hour < 18) {
            return 2;
        }
        return 3;
    }
}
