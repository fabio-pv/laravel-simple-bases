<?php

namespace LaravelSimpleBases\Exceptions;


use LaravelSimpleBases\Utils\StatusCodeUtil;
use Throwable;

class AuthenticationException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->statusCode = StatusCodeUtil::UNAUTHORIZED;
        parent::__construct($message, $code, $previous);
    }
}
