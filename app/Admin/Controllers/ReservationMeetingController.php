<?php

namespace App\Admin\Controllers;

use App\Models\MeetingRoom;
use App\Models\ReservationMeeting;
use App\Models\User;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ReservationMeetingController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(ReservationMeeting::with(['room'])->orderBy('date','desc'), function (Grid $grid) {
            $grid->scrollbarX();
            $grid->showColumnSelector();
            $grid->column('id');
            $grid->column('title');
            $grid->column('room.title');
            $grid->column('user_id')->hide();
            $grid->column('meeting_remark');
            $grid->column('person_name', '预约人')->display(function ($val) {
                return "姓名:$val <br>电话:{$this->person_phone}";
            });
            $grid->column('date')->display(function ($val) {
                return Carbon::parse($val)->toDateString();
            });
            $grid->column('start', '预约时间')->display(function ($val) {
                return "$val ~ {$this->end}";
            });
            $grid->column('status')->using(ReservationMeeting::STATUS_LIST)->label([
                0 => 'brown',
                1 => 'green',
                2 => 'blue',
                3 => 'red'
            ]);
            $grid->column('close_image')->image();
            $grid->column('close_remark');
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new ReservationMeeting(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('room_id');
            $show->field('meeting_remark');
            $show->field('person_name');
            $show->field('person_phone');
            $show->field('start');
            $show->field('end');
            $show->field('end_point');
            $show->field('status');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ReservationMeeting(), function (Form $form) {
            $form->display('id');
            $form->text('title')->required();
            $form->text('meeting_remark');
            $form->select('user_id')->options(User::toOptions())->required();
            $form->select('room_id')->options(MeetingRoom::toOptions())->required();
            $form->text('person_name')->required();
            $form->tel('person_phone')->required();
            $form->date('date', '预约日期')->required();
            $form->newTimeRange('start', 'end', '预约时间')->steping(30)->required();
//            $form->text('end');
//            $form->hidden('end_point');
            $form->radio('status')
                ->options(ReservationMeeting::STATUS_LIST)
                ->default(1)
                ->when(2, function (Form $form) {
                    $form->image('close_image')->autoUpload()->removable();
                    $form->text('close_remark');
                });

            $form->saving(function (Form $form) {
                if (!$form->isEditing())
                    if (!ReservationMeeting::checkCurrentDateIsValid($form->input('room_id'), $form->input('date'), $form->input('start'), $form->input('end')))
                        return $form->validationErrorsResponse([
                            'start' => '该时段不能再预约'
                        ]);
            });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
