<?php

namespace Howous\UiWidget\Form\Field;

use Encore\Admin\Form\Field\Currency;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/31
 * Time: 16:09
 */
class PretreatCurrency extends Currency
{
    protected $symbol='￥';

    public function value($value = null)
    {
        $error = \Request::session()->exists('errors');
        if (is_null($value)) {
            if ($error) {
                $right_operand = 1;     //原值保存在session中,下次直接取出时 不除以100
            }else{
                $right_operand = 100;
            }
            return is_null($this->value) ? $this->getDefault() : bcdiv($this->value, $right_operand, 2);
        }

        $this->value = $value;

        return $this;
    }

    public function prepare($value)
    {
        return bcmul($value, 100);
    }
}