<?php


namespace LaravelSimpleBases\Providers;


use Illuminate\Support\ServiceProvider;
use LaravelSimpleBases\Commands\KrloveEloquentModelGeneratorConfig;

class LaravelSimpleBaseProvider extends ServiceProvider
{

    public function register()
    {
        $this->commands([
            KrloveEloquentModelGeneratorConfig::class,
        ]);
    }

}
