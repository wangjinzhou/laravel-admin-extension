<?php

namespace Howous\UiWidget\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class FilterStateButton extends AbstractTool
{
    protected $options;
    protected $para_name;

    public function __construct($options,$para_name)
    {
        $this->options=$options;
        $this->para_name = $para_name;
    }

    protected function script()
    {
        // 去除之前的过滤条件
        $url = Request::url()."?{$this->para_name}=_verify_";
        return <<<EOT

$('input:radio.is_verify').change(function () {

    var url = "$url".replace('_verify_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = $this->options;

        return view('admin_ext::tools.recruitstate', compact('options'));
    }
}
