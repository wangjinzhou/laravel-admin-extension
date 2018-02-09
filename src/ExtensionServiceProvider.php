<?php

namespace Howous;

use Encore\Admin\Form;
use Howous\UiWidget\Form\Field\CnyCurrency;
use Howous\UiWidget\Form\Field\PretreatCurrency;
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
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'laravel-admin-extension-migrations');
            $this->publishes([__DIR__ . '/../resources/assets' => public_path('vendor/howous-admin-extension')], 'laravel-admin-extension-assets');
        }

        WebConfigExtension::load();
        WebConfigExtension::boot();

        $this->registerFields();
    }
    
    
    
    protected function registerFields()
    {
        Form::extend('pretreatCurrency', PretreatCurrency::class);
        PlainForm::setBuiltinFields();
        PlainForm::extend('cnyCurrency', CnyCurrency::class);
        PlainForm::extend('pretreatCurrency', PretreatCurrency::class);
    }
}