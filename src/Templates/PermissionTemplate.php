<?php


namespace LaravelSimpleBases\Templates;


class PermissionTemplate extends BaseTemplate
{
    
    protected $type = BaseTemplate::PERMISSION_TYPE;
    protected $template = '<?php


namespace App\Http\Permissions\__VERSION__;


use LaravelSimpleBases\Http\Permissions\BasePermission;

class __CLASS__Permission extends BasePermission
{


    protected $permissions = [
    ];

}
';
    
    public static function instance()
    {
        return new PermissionTemplate();
    }
    

}