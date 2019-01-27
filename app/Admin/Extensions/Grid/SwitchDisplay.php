<?php

namespace App\Admin\Extensions\Grid;

/**
 * 修改默认开关的文案（改为中文）
 * 可增加静态方法，实现动态修改文案
 *
 * @package App\Admin\Extensions\Form
 */
class SwitchDisplay extends \Encore\Admin\Grid\Displayers\SwitchDisplay
{
    protected $states = [
        'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
    ];

}