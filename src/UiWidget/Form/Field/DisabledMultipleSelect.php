<?php

namespace App\Admin\Extensions\Form\Field;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form\Field\Select;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * Class DisabledSelect
 *
 * @package App\Admin\Extensions\Form
 *    options 数组格式
 *          [
 *       1  =>
 *          ['title'=>值，'disabled'=>true ]
 * ]
 *          title用于显示    disabled用于判断是否禁选option
 */

class DisabledMultipleSelect extends Select
{
    protected $view = 'admin_ext::form.field.disabledmultipleselect';
}


