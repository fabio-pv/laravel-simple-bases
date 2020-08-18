<?php


namespace LaravelSimpleBases\Http\Permissions;


interface HandlePermissionInterface
{
    public static function handle($user);

    public static function message(): string;
}
