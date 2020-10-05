<?php


namespace LaravelSimpleBases\Utils;


use Illuminate\Support\Facades\Auth;

trait ValidationUtil
{

    protected function ruleFor(string $rule, array $roles): string
    {
        $userModel = Auth::user();
        if(empty($userModel)){
            return '';
        }

        if (in_array($userModel->userRole->id, $roles)) {
            return $rule;
        }

        return '';
    }

}
