<?php

namespace LaravelSimpleBases\Exceptions;


use LaravelSimpleBases\Utils\StatusCodeUtil;
use Throwable;

class ValidationException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = StatusCodeUtil::BAD_REQUEST;
    }
}
