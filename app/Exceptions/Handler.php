<?php

namespace App\Exceptions;

use App\Facades\Response;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     * @var array
     */
    protected $dontReport = [
        RepoException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthorizationException) {
            $code = 403;
            $msg = '资源不存在或没有权限访问，请尝试刷新重试！';
        } elseif ($exception instanceof RepoException) {
            //自定义异常
            $code = 200;
            $msg = $exception->getMessage();
        } elseif ($exception instanceof TokenException) {
            //token异常
            $code = 401;
            $msg = $exception->getMessage();
        } else {
            $code = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : $exception->getCode();
            if ($code == 400) {
                $payload = json_decode($exception->getMessage(), true);
                $msg = $payload['msg'];
                $errors = $payload['errors'];
            } else {
                $msg = $exception->getMessage();
            }
        }

        $response = [
            'msg' => $msg,
            'code' => $code,
        ];

        if (config('app.env') !== 'production') {
            $response['file'] = $exception->getFile();
            $response['line'] = $exception->getLine();
        }
        $response['errors'] = $errors ?? [];

        return Response::fail(
            $msg,
            $response,
            isset(FoundationResponse::$statusTexts[$code]) ? $code : FoundationResponse::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
