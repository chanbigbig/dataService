<?php
/**
 * Created by PhpStorm.
 * User: code
 * Date: 2018/3/5
 * Time: 下午2:54
 */

namespace App\Admin\Extensions\Form;


class SwitchField extends \Encore\Admin\Form\Field\SwitchField
{


    protected $states = [
        'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
    ];


}