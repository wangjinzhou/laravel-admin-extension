<?php

namespace Howous;

use Encore\Admin\Form;
use Howous\UiWidget\Form\Field\CnyCurrency;
use Howous\UiWidget\Form\Field\DisabledMultipleSelect;
use Howous\UiWidget\Form\Field\DisabledSelect;
use Howous\UiWidget\Form\Field\MyImage;
use Howous\UiWidget\Form\Field\PretreatCurrency;
use Howous\UiWidget\Form\Field\TinyMCE;
use Howous\UiWidget\Form\PlainForm;
use Howous\WebConfig\WebConfigExtension;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9
 * Time: 16:17
 */
class ExtensionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin_ext');

        if ($this->app->runningInConsole()) {
            //            $this->loadMigrationsFrom(__DIR__ . '../database/migirations');
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'howous-laravel-admin-extension');
            $this->publishes([__DIR__ . '/../resources/assets' => public_path('vendor/howous-admin-extension')], 'howous-laravel-admin-extension');
        }


        WebConfigExtension::boot();

        $this->registerFields();
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