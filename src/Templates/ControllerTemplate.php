<?php

namespace LaravelSimpleBases\Templates;

class ControllerTemplate extends BaseTemplate
{

    protected $type = BaseTemplate::CONTROLLER_TYPE;
    protected $template = '<?php

namespace App\Http\Controllers\__VERSION__;

use App\Http\Validations\__VERSION__\__CLASS__Validation;
use App\Models\__VERSION__\__CLASS__;
use App\Services\__VERSION__\__CLASS__Service;
use App\Transformers\__VERSION__\__CLASS__Transformer;
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

    public static function instance()
    {
        return new ControllerTemplate();
    }
}
