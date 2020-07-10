<?php


namespace LaravelSimpleBases\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use LaravelSimpleBases\Exceptions\BaseException;
use LaravelSimpleBases\Utils\StatusCodeUtil;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

abstract class BaseHandlerException extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {

        if (get_parent_class($exception) === BaseException::class) {
            return $exception->response();
        }

        if (get_class($exception) === NotFoundHttpException::class) {
            return response_exception(
                'Route not found',
                StatusCodeUtil::BAD_REQUEST,
                $exception->getFile(),
                $exception->getLine(),
                $exception->getTraceAsString(),
            );
        }

        return response_exception(
            $exception->getMessage(),
            StatusCodeUtil::INTERNAL_SERVER_ERROR,
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString(),
            [],
            true
        );
    }
}
