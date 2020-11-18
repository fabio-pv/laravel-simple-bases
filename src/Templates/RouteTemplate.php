<?php


namespace LaravelSimpleBases\Templates;


use Illuminate\Support\Facades\App;

class RouteTemplate
{
    public static function make(string $name, string $version = null): void
    {

        $routeTemplate = new RouteTemplate();

        if (empty($version)) {
            $version = 'v1';
        }

        $dest = getcwd() . '/routes/api.php';
        $newName = $output = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

        $data = PHP_EOL . '/**
* Route generate by laravel-simple-base
* Make the necessary adjustments before using
*/' . PHP_EOL;
        $routeTemplate->write($dest, $data);

        $data = $routeTemplate->makeRouteByVerionLaravel($routeTemplate, $version, $newName, $name);
        $routeTemplate->write($dest, $data);

        echo 'Create new Route in api.php';
        echo PHP_EOL;

    }

    private function makeRouteByVerionLaravel($instance, $version, $newName, $name)
    {
        if (App::version() >= '8.0') {
            return $instance->routeForLessEqualLaravel8($version, $newName, $name);
        }
        return $instance->routeForLessEqualLaravel7($version, $newName, $name);
    }

    private function routeForLessEqualLaravel7(string $version, string $nameRoute, string $nameController)
    {
        return "Route::apiResource('{$version}/{$nameRoute}', '${version}\\{$nameController}Controller');";
    }

    private function routeForLessEqualLaravel8(string $version, string $nameRoute, string $nameController)
    {
        $controller = '\App\Http\Controllers\\'
            . $version
            . '\\'
            . $nameController
            . 'Controller::class';

        return "Route::apiResource('{$version}/{$nameRoute}', $controller);";
    }

    private function write(string $dest, string $data)
    {
        file_put_contents(
            $dest,
            $data,
            FILE_APPEND
        );
    }

}
