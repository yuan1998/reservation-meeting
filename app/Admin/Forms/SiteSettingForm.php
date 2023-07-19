<?php

namespace App\Admin\Forms;

use App\Clients\CrmClient;
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
