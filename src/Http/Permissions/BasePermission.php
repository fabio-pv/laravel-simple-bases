<?php


namespace LaravelSimpleBases\Http\Permissions;


use Illuminate\Support\Facades\Auth;
use LaravelSimpleBases\Exceptions\ValidationException;

abstract class BasePermission
{

    protected $permissions;

    public function verify(string $functionName)
    {

        $userModel = Auth::user();
        $currentUserRole = $userModel->userRole->id;
        $needRole = $this->permissions[$functionName] ?? null;

        if (empty($needRole)) {
            return;
        }

        if (in_array($currentUserRole, $needRole)) {
            return;
        }

        throw new ValidationException('your user does not have access to this feature');

    }


}
