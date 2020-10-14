<?php


namespace LaravelSimpleBases\Templates;


use Illuminate\Support\Facades\Artisan;

class TransformerTemplate
{

    public static function make(string $name, string $version = null): void
    {
        if (empty($version)) {
            $version = 'v1';
        }

        Artisan::call('make:transformer ' . $version . '/' . $name . 'Transformer');

        echo 'Create Transformer: ' . $name . '.php';
        echo PHP_EOL;
    }

}
