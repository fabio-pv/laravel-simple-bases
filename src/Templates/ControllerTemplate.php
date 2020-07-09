<?php

namespace LaravelSimpleBases\Templates;

class ControllerTemplate extends BaseTemplate
{

    private const template = '<?php

namespace App\Http\Controllers\v1;

use App\Http\Validations\v1\__CLASS__Validation;
use App\Models\v1\__CLASS__;
use App\Services\v1\__CLASS__Service;
use App\Transformers\v1\__CLASS__Transformer;
use LaravelSimpleBases\Http\Controllers\BaseController;

class __CLASS__Controller extends BaseController
{
    public function __construct(
        __CLASS__ __VARIABLE__,
        __CLASS__Transformer __VARIABLE__Transformer,
        __CLASS__Validation __VARIABLE__Validation
    )
    {
        $this->model = __VARIABLE__;
        $this->service = new __CLASS__Service($this->model);
        $this->transformer = __VARIABLE__Transformer;
        $this->validation = __VARIABLE__Validation;
    }
}
';

    public function __construct()
    {
        $this->template = self::template;
        $this->type = BaseTemplate::CONTROLLER_TYPE;
    }

    public static function instance()
    {
        return new ControllerTemplate();
    }
}
