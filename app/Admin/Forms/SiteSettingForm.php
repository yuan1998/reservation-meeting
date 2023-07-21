<?php

namespace App\Admin\Forms;

use App\Clients\CrmClient;
use App\Models\User;
use Dcat\Admin\Form\EmbeddedForm;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;

class SiteSettingForm extends Form
{


    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        admin_setting($input);
        return $this
            ->response()
            ->success('保存配置成功');
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->switch("DISABLE_RESERVATION", '禁止预约');
        $this->textarea("DEFAULT_REMARK", '默认归还备注');
        $this->number('RESERVATION_MAX', '最大预约数量(0表示不限制)')->default(0)->min(0);

        $this->divider();
        $this->switch('ENABLE_POST', '启动预约推送');
        $this->text('DINGDING_ROBOT', '钉钉机器人webhook');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return admin_setting()->toArray();
    }
}
