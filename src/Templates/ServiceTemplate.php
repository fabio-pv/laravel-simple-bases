<?php


namespace LaravelSimpleBases\Templates;


class ServiceTemplate extends BaseTemplate
{

    protected $type = BaseTemplate::SERVICE_TYPE;
    protected $template = '<?php


namespace App\Services\__VERSION__;


use LaravelSimpleBases\Services\BaseService;

class __CLASS__Service extends BaseService
{
}';

    public static function instance()
    {
        return new ServiceTemplate();
    }

}
