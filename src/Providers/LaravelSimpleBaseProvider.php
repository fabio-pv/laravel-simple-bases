<?php


namespace LaravelSimpleBases\Providers;


use Illuminate\Support\ServiceProvider;
use LaravelSimpleBases\Commands\FromToDataConfig;
use LaravelSimpleBases\Commands\GenerateEndpointClass;
use LaravelSimpleBases\Commands\GeneratePermissionClass;
use LaravelSimpleBases\Commands\GeneratePermissionHandle;
use LaravelSimpleBases\Commands\KrloveEloquentModelGeneratorConfig;
use LaravelSimpleBases\Commands\ModelWithFileConfig;

class LaravelSimpleBaseProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    public function register()
    {
        $this->commands([
            KrloveEloquentModelGeneratorConfig::class,
            FromToDataConfig::class,
            ModelWithFileConfig::class,
            GenerateEndpointClass::class,
            GeneratePermissionClass::class,
            GeneratePermissionHandle::class
        ]);
    }

}
