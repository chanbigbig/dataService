<?php
/**
 * Created by PhpStorm.
 * User: chenjianlin
 * Date: 2018/5/18
 * Time: 下午3:09
 */

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertStringBooleans extends TransformsRequest
{
    protected function transform($key, $value)
    {
        if (strtolower($value) === 'true') {
            return true;
        }

        if (strtolower($value) === 'false') {
            return false;
        }

        if ($value === null) {
            return '';
        }

        return $value;
    }
}