<?php

namespace LaravelSimpleBases\src\Exceptions;


use LaravelSimpleBases\src\Utils\StatusCodeUtil;
use Throwable;

class ValidationFieldException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = StatusCodeUtil::BAD_REQUEST;
    }
}
