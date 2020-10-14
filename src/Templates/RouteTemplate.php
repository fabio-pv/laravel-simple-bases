<?php


namespace LaravelSimpleBases\Templates;


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
* Realize os ajuste necessarios antes de usar
*/' . PHP_EOL;
        $routeTemplate->write($dest, $data);

        $data = $routeTemplate->routeForLessEqualLaravel7($version, $newName, $name);
        $routeTemplate->write($dest, $data);

        echo 'Create new Route in api.php';
        echo PHP_EOL;

    }

    private function routeForLessEqualLaravel7(string $version, string $nameRoute, string $nameController)
    {
        return "Route::apiResource('{$version}/{$nameRoute}', '${version}\\{$nameController}Controller');";
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
