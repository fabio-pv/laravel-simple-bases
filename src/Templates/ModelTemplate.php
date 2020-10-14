<?php


namespace LaravelSimpleBases\Templates;


use Illuminate\Support\Facades\Artisan;

class ModelTemplate
{
    public static function make(string $name, string $tableName): void
    {
        Artisan::call(
            'krlove:generate:model ' .
            $name .
            ' --table-name=' .
            $tableName
        );

        echo 'Create Model: ' . $name . '.php';
        echo PHP_EOL;

    }
}
