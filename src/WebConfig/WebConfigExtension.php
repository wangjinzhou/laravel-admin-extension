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
}