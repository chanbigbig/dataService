<?php


namespace App\Repositories;

/**
 * 订单业务逻辑
 * Class OrderRepo
 * @package App\Repositories
 */

class OrderRepo
{

    /**
     * 获取订单编号
     */
    public function getOrderId()
    {
        $result = $this->udate('YmdHisu');
        return $result;
    }


    function udate($format = 'u', $utimestamp = null)
    {
        if (is_null($utimestamp)) {
            $utimestamp = microtime(true);
        }
        $timestamp = floor($utimestamp);
        $milliseconds = round(($utimestamp - $timestamp) * 1000000);//改这里的数值控制毫秒位数
        return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
    }


}