<?php


namespace LaravelSimpleBases\Providers;


use Illuminate\Support\ServiceProvider;
use LaravelSimpleBases\Commands\KrloveEloquentModelGenerator;

class LaravelSimpleBaseProvider extends ServiceProvider
{

    const PROCESSOR_TAG = 'laravel_simple_bases.processor';

    public function register()
    {
        $this->commands([
            KrloveEloquentModelGenerator::class,
        ]);
    }

}
