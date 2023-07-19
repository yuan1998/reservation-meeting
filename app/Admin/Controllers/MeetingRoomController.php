<?php

namespace App\Admin\Controllers;

use App\Models\MeetingRoom;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MeetingRoomController extends AdminController
{
    protected $title = '会议室房间';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new MeetingRoom(), function (Grid $grid) {
            $grid->model()
                ->orderBy('order');
            $grid->sortable();
            $grid->column('id');
            $grid->column('title');
            $grid->column('capacity');
            $grid->column('tools');
            $grid->column('enable')->switch();
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');

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
        return Show::make($id, new MeetingRoom(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('capacity');
            $show->field('tools');
            $show->field('open_time');
            $show->field('close_time');
            $show->field('enable');
            $show->field('need_audit');
            $show->field('order');
            $show->field('remark');
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
        return Form::make(new MeetingRoom(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('remark');
            $form->number('capacity')->min(0)->default(10);
            $form->checkbox('tools')->options([
                '投影仪' => '投影仪',
                '白板' => '白板',
                '音箱' => '音箱',
                '话筒' => '话筒',
            ]);
            $form->switch('enable')->default(1);
            $form->hidden('order')->default(0);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
