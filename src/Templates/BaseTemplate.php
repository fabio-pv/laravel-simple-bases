<?php

namespace LaravelSimpleBases\Templates;

abstract class BaseTemplate
{
    private const types = [
        'Controller' => '/app/Http/Controllers/',
        'Service' => '/app/Services/',
        'Validation' => '/app/Http/Validations/'
    ];

    protected const CONTROLLER_TYPE = 'Controller';
    protected const SERVICE_TYPE = 'Service';
    protected const VALIDATION_TYPE = 'Validation';

    private const CODE_MARKER_CLASS = '__CLASS__';
    private const CODE_MARKER_VARIABLE = '__VARIABLE__';
    private const CODE_MARKER_VERSION = '__VERSION__';

    protected $template;
    protected $type;

    public function make(string $newName, string $version = null): void
    {
        $codeCreate = $this->createCode($newName, $version);
        $fileName = $this->createFile($newName, $codeCreate, $version);

        echo 'Create ' . $this->type . ': ' . $fileName;
        echo PHP_EOL;
    }

    private function createCode(string $newName, string $version = null): string
    {
        if(empty($version)) {
            $version = 'v1';
        }

        $variableName = '$' . lcfirst($newName);
        $codeCreate = str_replace(self::CODE_MARKER_CLASS, $newName, $this->template);
        $codeCreate = str_replace(self::CODE_MARKER_VARIABLE, $variableName, $codeCreate);
        $codeCreate = str_replace(self::CODE_MARKER_VERSION, $version, $codeCreate);

        return $codeCreate;
    }

    private function createFile(string $name, string $codeCreate, string $version = null): string
    {
        $fileName = $name . $this->type . '.php';
        $dir = getcwd() . self::types[$this->type];
        $dir = $this->addVersion($dir, $version);
        $dirFile = $dir . $fileName;

        if (!is_dir($dir)) {
            mkdir($dir);
        }

        file_put_contents($dirFile, $codeCreate, FILE_TEXT);

        return $fileName;

    }

    private function addVersion(string $dir, string $version = null) : string
    {
        if(empty($version)){
            return  $dir . 'v1/';
        }

        return  $dir . $version . '/';

    }

}
