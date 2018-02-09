<?php
namespace Howous;
use Howous\WebConfig\WebConfigExtension;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9
 * Time: 16:17
 */
class WebConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '../database/migirations');
        }

        WebConfigExtension::load();
    }
}