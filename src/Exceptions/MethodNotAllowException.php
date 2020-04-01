<?php

namespace LaravelSimpleBases\Exceptions;


use LaravelSimpleBases\Utils\StatusCodeUtil;
use Throwable;

class MethodNotAllowException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = StatusCodeUtil::METHOD_NOT_ALLOWED;
        $this->message = 'Method not allow';

    }
}
