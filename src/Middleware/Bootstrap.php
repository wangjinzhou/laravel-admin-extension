<?php

namespace Howous\Middleware;

use Encore\Admin\Form;
use Howous\UiWidget\Form\Field\CnyCurrency;
use Howous\UiWidget\Form\Field\DisabledMultipleSelect;
use Howous\UiWidget\Form\Field\DisabledSelect;
use Howous\UiWidget\Form\Field\MyImage;
use Howous\UiWidget\Form\Field\PretreatCurrency;
use Howous\UiWidget\Form\Field\TinyMCE;
use Howous\UiWidget\Form\PlainForm;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/12
 * Time: 18:16
 */
class Bootstrap
{
    public function handle(Request $request,\Closure $next)
    {
        $this->registerFields();
        return $next($request);
    }
    
    
    protected function registerFields()
    {
        Form::extend('pretreatCurrency', PretreatCurrency::class);
        Form::extend('disabledSelect',DisabledSelect::class);
        Form::extend('disabledMultipleSelect',DisabledMultipleSelect::class);
        Form::extend('myImage',MyImage::class);
        PlainForm::setBuiltinFields();
        PlainForm::extend('cnyCurrency', CnyCurrency::class);
        PlainForm::extend('pretreatCurrency', PretreatCurrency::class);
        PlainForm::extend('editor',TinyMCE::class);
        PlainForm::extend('image',MyImage::class);
    }
}