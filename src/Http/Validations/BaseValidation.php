<?php


namespace LaravelSimpleBases\Http\Validations;


use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use LaravelSimpleBases\Exceptions\ValidationFieldException;

abstract class BaseValidation
{

    const CREATE = 'store';
    const UPDATE = 'update';

    protected $fieldsCreate = [];
    protected $fieldsUpdate = [];
    protected $fieldMethod = [];

    public function validate(Request $request, $method)
    {

        $fields = null;

        if ($method === self::CREATE) {
            $fields = $this->fieldsCreate;
        }

        if ($method === self::UPDATE) {
            $fields = $this->fieldsUpdate;
        }

        if (empty($fields)) {
            $fields = $this->getFieldByMethod($method);
        }

        $validator = \Validator::make($request->all(), $fields);

        if (!$validator->fails()) {
            return;
        }

        $this->makeMessage($validator->errors());

    }

    private function getFieldByMethod($method)
    {
        return $this->fieldMethod[$method] ?? [];
    }

    private function makeMessage(MessageBag $erros)
    {

        $exception = new ValidationFieldException('your request does not meet the requirements');
        $exception->setFields($erros->getMessages());

        throw $exception;

    }
}
