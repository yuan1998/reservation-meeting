<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->scrollbarX();
            $grid->showColumnSelector();
            $grid->column('id')->sortable();

            $grid->column('avatar')->image('',50 ,50);
            $grid->column('nike_name');
            $grid->column('name');
            $grid->column('phone');
            $grid->column('language')->hide();
            $grid->column('country');
            $grid->column('province');
            $grid->column('city');
            $grid->column('gender')->using(User::GENDER_LIST);
            $grid->column('enable')->switch();
            $grid->column('openid')->hide();
            $grid->column('session_key')->hide();
            $grid->column('unionid')->hide();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('avatar');
            $show->field('nike_name');
            $show->field('language');
            $show->field('province');
            $show->field('country');
            $show->field('city');
            $show->field('gender');
            $show->field('openid');
            $show->field('session_key');
            $show->field('unionid');
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->text('avatar');
            $form->text('nike_name');
            $form->text('language');
            $form->text('province');
            $form->text('country');
            $form->text('city');
            $form->text('gender');
            $form->text('openid');
            $form->text('session_key');
            $form->text('unionid');
            $form->switch('enable')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
