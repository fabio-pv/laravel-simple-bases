<?php

namespace LaravelSimpleBases\Templates;

abstract class BaseTemplate
{
    private const types = [
        'Controller' => '/app/Http/Controllers/v1/',
        'Service' => '/app/Services/v1/',
        'Validation' => '/app/Http/Validations/v1/'
    ];

    protected const CONTROLLER_TYPE = 'Controller';
    protected const SERVICE_TYPE = 'Service';
    protected const VALIDATION_TYPE = 'Validation';

    private const CODE_MARKER_CLASS = '__CLASS__';
    private const CODE_MARKER_VARIABLE = '__VARIABLE__';

    protected $template;
    protected $type;

    public function make(string $newName): void
    {
        $codeCreate = $this->createCode($newName);
        $fileName = $this->createFile($newName, $codeCreate);

        echo 'Create ' . $this->type . ': ' . $fileName;
        echo PHP_EOL;
    }

    private function createCode(string $newName): string
    {
        $variableName = '$' . lcfirst($newName);
        $codeCreate = str_replace(self::CODE_MARKER_CLASS, $newName, $this->template);
        $codeCreate = str_replace(self::CODE_MARKER_VARIABLE, $variableName, $codeCreate);

        return $codeCreate;
    }

    private function createFile(string $name, string $codeCreate): string
    {
        $fileName = $name . $this->type . '.php';
        $dir = getcwd() . self::types[$this->type] . $fileName;

        file_put_contents($dir, $codeCreate, FILE_TEXT);

        return $fileName;

    }

}
