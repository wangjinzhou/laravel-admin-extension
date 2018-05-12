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
    protected $routeMiddleware = [
        'howous.bootstrap' => \Howous\Middleware\Bootstrap::class,
    ];

    protected $middlewareGroups = [
        'h_admin' => [
            'howous.bootstrap'
        ]
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin_ext');

        if ($this->app->runningInConsole()) {
            //            $this->loadMigrationsFrom(__DIR__ . '../database/migirations');
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'howous-laravel-admin-extension');
            $this->publishes([__DIR__ . '/../resources/assets' => public_path('vendor/howous-admin-extension')], 'howous-laravel-admin-extension');
        }


        WebConfigExtension::boot();
    }

    public function register()
    {
        $this->registerMiddleware();
    }

    private function registerMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}