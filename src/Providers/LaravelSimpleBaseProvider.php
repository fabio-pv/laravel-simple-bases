<?php


namespace LaravelSimpleBases\Providers;


use Illuminate\Support\ServiceProvider;
use LaravelSimpleBases\Commands\FromToDataConfig;
use LaravelSimpleBases\Commands\GenerateEndpointClass;
use LaravelSimpleBases\Commands\KrloveEloquentModelGeneratorConfig;
use LaravelSimpleBases\Commands\ModelWithFileConfig;

class LaravelSimpleBaseProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
    }

    public function register()
    {
        $this->commands([
            KrloveEloquentModelGeneratorConfig::class,
            FromToDataConfig::class,
            ModelWithFileConfig::class,
            GenerateEndpointClass::class,
        ]);
    }

}
