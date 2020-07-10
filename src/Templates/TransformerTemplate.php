<?php


namespace LaravelSimpleBases\Templates;


use Illuminate\Support\Facades\Artisan;

class TransformerTemplate
{

    public static function make(string $name): void
    {
        Artisan::call('make:transformer v1/' . $name . 'Transformer');
    }

}