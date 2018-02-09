<?php
namespace Howous\WebConfig;
use Encore\Admin\Extension;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9
 * Time: 16:43
 */
class WebConfigExtension extends Extension
{
    public static function load()
    {
        foreach (WebConfig::all(['name', 'value'])->toArray() as $config) {
            config([$config['name'] => $config['value']]);
        }
    }

    public static function boot()
    {
        static::registerRoutes();
    }

    protected static function registerRoutes()
    {
        parent::routes(function($route){
            /* @var \Illuminate\Routing\Router $router */
            $router->get('/web-config/all', 'WebConfigController@edit');    //配置编辑展示
            $router->put('/web-config/all', 'WebConfigController@update');
        });
    }
}