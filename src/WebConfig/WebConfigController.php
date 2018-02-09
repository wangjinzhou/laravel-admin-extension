<?php

namespace Howous\WebConfig;

use Encore\Admin\Form\Field;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Howous\UiWidget\Form\PlainForm;

class WebConfigController
{
    use ModelForm;

    protected $name = '配置管理';


    /**
     * Edit interface.
     *
     *
     * @return Content
     */
    public function edit()
    {
        return \Admin::content(function (Content $content) {

            $content->header($this->name);
            $content->description('编辑');

            $content->body($this->getPlainForm());
        });
    }


    public function update()
    {
        $plain_form = $this->getPlainForm();

        $plain_form->store();
    }

    /**
     * @return PlainForm
     */
    protected function getPlainForm()
    {
        $all_configs = WebConfig::all();
        $model       = new WebConfig();
        $plain_from  = new PlainForm($model);

        foreach ($all_configs as $item) {
            $type = $item->field_type;

            $rules = $item->field_rules ?? '';
            $help  = $item->description;
            /** @var Field $field_control */
            $field_control = null;
            if ($type == 'switch') {
                $states = [
                    'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
                ];
                $field_control = $plain_from->$type($item->name, $item->title)->states($states)->rules($rules);
            } else {
                $field_control = $plain_from->$type($item->name, $item->title)->rules($rules);
            }
            if (!empty($help)) {
                $field_control = $field_control->help($help);
            }
            $field_control->value($item->value);
        }

        return $plain_from;
    }

}
