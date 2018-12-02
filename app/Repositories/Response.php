<?php

/**
 * 请求响应封装
 */


namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class Response
{
    /**
     * 成功消息
     * @param $message
     * @param array $data
     * @return mixed
     */
    public function success($message = '成功', $data = [])
    {
        return $this->message($message, $data, 0);
    }


    /**
     * 一般消息
     * @param $message
     * @param array $data
     * @param int $errorCode
     * @param int $statusCode
     * @return mixed
     */
    public function message($message, $data = [], $errorCode = 1, $statusCode = FoundationResponse::HTTP_OK)
    {

        $response = [
            'error_code' => $errorCode,
            'message' => $message,
            'data' => $data,
        ];
        if (config('app.env') != 'production') {
            $response['querys'] =  DB::getQueryLog();
        }
        if (request()->wantsJson()) {
            return response()->json($response, $statusCode);
        }
        return response($response, $statusCode);
    }


    /**
     * 错误消息 [http协议层错误]
     * @param $message
     * @param array $data
     * @param int $statusCode
     * @return mixed
     */
    public function fail($message = '失败', $data = [], $statusCode = FoundationResponse::HTTP_FORBIDDEN)
    {
        return $this->message($message, $data, $statusCode, $statusCode);
    }
}
