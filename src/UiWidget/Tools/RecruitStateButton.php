<?php

namespace Howous\UiWidget\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class RecruitStateButton extends AbstractTool
{
    protected $options;

    public function __construct($options)
    {
        $this->options=$options;
    }

    protected function script()
    {
        $url = Request::fullUrlWithQuery(['is_verify' => '_verify_']);

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
