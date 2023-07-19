<?php

namespace App\Admin\Form\Field;

use Dcat\Admin\Form\Field\TimeRange;

class NewTimeRange extends TimeRange
{
    protected $format = 'HH:mm';

    protected $view = 'admin::form.timerange';

    public function __construct($column, $arguments)
    {
        parent::__construct($column, $arguments);
    }

    public function steping($val) {
        $this->options(['stepping' => $val]);
        return $this;
    }

    public function render()
    {
        $r = parent::render();
        return $r;
    }
}
