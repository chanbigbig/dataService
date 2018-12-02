<?php

namespace App\Http\Controllers;

use App\Facades\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 成功消息
     * @param $message
     * @param array $data
     * @return mixed
     */
    public function success($message = '操作成功', $data = [])
    {
        return $this->message($message, $data, 0);
    }

    /**
     * 返回数据
     * @param $data
     * @param string $message
     * @return mixed
     */
    public function successData($data, $message = '成功')
    {
        return $this->message($message, $data, 0);
    }

    /**
     * 返回数据 根据数据来确定是返回成功还是失败
     * @param $data
     * @param string $message
     * @return mixed
     */
    public function response($data, $message = '')
    {
        if ($data instanceof \Illuminate\Support\Collection) {
            $data = $data->toArray();
        }
        if ($data) {
            return $this->successData($data, $message ?: '成功');
        }
        return $this->message($message ?: '失败', $data);
    }


    /**
     * 一般消息
     * @param $message
     * @param array $data
     * @param int $errorCode
     * @param int $statusCode
     * @return mixed
     */
    public function message($message = '', $data = [], $errorCode = 1, $statusCode = FoundationResponse::HTTP_OK)
    {
        return Response::message($message, $data, $errorCode, $statusCode);
    }


    /**
     * 参数验证器
     * @param $request
     * @param array $rules
     * @param string $msg
     * @return array
     */
    public function validate($request, array $rules, $msg = '参数错误')
    {
        if (is_array($request)) {
            $data = $request;
        } else {
            $data = $request->all();
        }
        $valid = validator($data, $rules);
        if ($valid->fails()) {
            $errors = $valid->errors()->all();
            abort(400, json_encode(['errors' => $errors, 'msg' => $msg]));
        }
        return $data;
    }

    /**
     * 排序基类
     *
     * @param array $validFields
     * @param string $prefix
     *
     * @return array
     */
    public function getDbSorts($validFields = [], $prefix = '')
    {
        // 取得查询字段
        $sortStr = app('request')->get('sort_by');

        if (empty($sortStr)) {
            return [];
        }

        $sorts = explode(',', $sortStr);

        $sortFields = [];
        foreach ($sorts as $sort) {

            $field = ltrim($sort, '-');

            if (!empty($prefix)) {
                $field = $prefix . '.' . $field;
            }

            if (in_array($field, $validFields)) {
                $order = starts_with($sort, '-') ? 'desc' : 'asc';
                $sortFields[$field] = $order;
            }
        }
        return $sortFields;
    }

    /**
     * 员工认证
     * @param $staffId
     */
    public function authStaff($staffId)
    {
        if (empty($staffId)) {
            return;
        }
        $this->authorize('access', Staff::getStaff($staffId));
    }

    /**
     * 单位认证
     * @param $entityId
     */
    public function authEntity($entityId)
    {
        if (empty($entityId)) {
            return;
        }
        $this->authorize('access', Entity::getEntity($entityId));
    }


    /**
     * 帐号认证
     * @param $accountId
     */
    public function authAccount($accountId)
    {
        if (empty($accountId)) {
            return;
        }
        $this->authorize('access', Account::getAccount($accountId));
    }
}
