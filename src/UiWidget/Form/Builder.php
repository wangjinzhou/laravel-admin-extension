<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 23:35
 */

namespace Howous\UiWidget\Form;

use Encore\Admin\Form\Field;
use Illuminate\Support\Collection;

class Builder
{
    protected $view = 'admin_ext::form.plain-form';

    protected $form = null;

    protected $action;

    protected $hiddenFields = [];

    /**
     * width for label and field
     *
     * @var array
     */
    protected $width = [
        'label' => 2,
        'field' => 8,
    ];

    /**
     * @var Collection|null
     */
    protected $fields = null;

    public function __construct(PlainForm $form)
    {
        $this->form = $form;

        $this->fields = new Collection();
    }

    public function fields()
    {
        return $this->fields;
    }


    /**
     * Submit button of form..
     *
     * @return string
     */
    public function submitButton()
    {

        $text = trans('admin.submit');

        return <<<EOT
<div class="btn-group pull-right">
    <button type="submit" class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin '></i> $text">$text</button>
</div>
EOT;
    }

    /**
     * Reset button of form.
     *
     * @return string
     */
    public function resetButton()
    {
        $text = trans('admin.reset');

        return <<<EOT
<div class="btn-group pull-left">
    <button type="reset" class="btn btn-warning">$text</button>
</div>
EOT;
    }


    /**
     * 表单开始标签( <from .. > )
     */
    public function open($options = [])
    {
        $attributes = [];

        $attributes['method'] = array_get($options, 'method','post');
        $attributes['action'] = $this->getAction();
        $attributes['accept-charset'] = 'UTF-8';
        $attributes['class'] = array_get($options, 'class');

        $this->pushHiddenField((new Field\Hidden('_method'))->value('PUT'));

        if ($this->hasFileField()) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        $html = [];
        foreach ($attributes as $key => $val) {
            $html[] = "$key=\"$val\"";
        }

        return '<form ' . implode(' ', $html) . ' pjax-container >';
    }

    public function close()
    {
        return '</form>';
    }

    public function hasFileField()
    {
        foreach ($this->fields() as $filed) {
            if ($filed instanceof Field\File) {
                return true;
            }
        }
        return false;
    }

    public function pushHiddenField(Field $field)
    {
        $this->hiddenFields[] = $field;
    }

    public function getHiddenFields()
    {
        return $this->hiddenFields;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function getAction()
    {
        if ($this->action) {
            return $this->action;
        }

        $this->action = $this->form->getUrl();

        return $this->action;
    }

    protected function getData()
    {
        return [
            'form' => $this,
            'width' => $this->width,
        ];
    }

    public function render()
    {
        return view($this->view, $this->getData())->render();
    }

}