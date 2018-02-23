<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/31
 * Time: 11:10
 */

namespace App\Admin\Extensions\Form\Field;


use Encore\Admin\Form\Field\Image;

class MyImage  extends Image
{
    public function prepare($image)
    {
        if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy();
        }

        $ext = $image->getClientOriginalExtension();

        $this->name= md5(uniqid('',true)) .'.'.$ext;

        $this->callInterventionMethods($image->getRealPath());

        return $this->uploadAndDeleteOriginal($image);
    }
}