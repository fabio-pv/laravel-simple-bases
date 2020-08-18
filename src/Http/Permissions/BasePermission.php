<?php


namespace LaravelSimpleBases\Http\Permissions;


use Illuminate\Support\Facades\Auth;
use LaravelSimpleBases\Exceptions\ValidationException;

abstract class BasePermission
{

    protected $permissions;

    private $message = 'Your user does not have access to this feature';

    public function verify(string $functionName)
    {

        $userModel = Auth::user();
        if (empty($userModel)) {
            return;
        }

        $handleRole = $this->getHandler($userModel);
        $needRole = $this->permissions[$functionName] ?? null;

        if (empty($needRole)) {
            return;
        }

        if (in_array($handleRole, $needRole)) {
            return;
        }

        throw new ValidationException($this->message);

    }

    private function getHandler($user = null)
    {
        try {

            $handle = 'App\Http\Permissions\HandlePermission';
            $result = call_user_func($handle . '::handle', $user);
            $this->message = call_user_func($handle . '::message');

            return $result;

        } catch (\Exception $e) {
            return $this->getHandlerDefault($user);
        }
    }

    private function getHandlerDefault($user = null)
    {
        return $user->userRole->id;
    }


}
