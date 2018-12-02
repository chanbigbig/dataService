<?php
/**
 * function description
 * @author: 罗会铸 yeyupl@qq.com
 * @created: 18/3/27 下午6:47
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Response extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Response';
    }
}
