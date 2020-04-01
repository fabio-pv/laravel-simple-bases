<?php

namespace LaravelSimpleBases\Exceptions;


use LaravelSimpleBases\Utils\StatusCodeUtil;
use Throwable;

class ModelNotFoundException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = 'Resource not found';
        $this->statusCode = StatusCodeUtil::BAD_REQUEST;
    }
}
