<?php

namespace LaravelSimpleBases\Templates;

abstract class BaseTemplate
{

    protected const CONTROLLER_TYPE = 'Controller';

    private const CODE_MARKER_CLASS = '__CLASS__';
    private const CODE_MARKER_VARIABLE = '__VARIABLE__';

    protected $template;
    protected $type;

    public function make(string $newName): void
    {
        $codeCreate = $this->createCode($newName);
        $fileName = $this->createFile($newName, $codeCreate);

        echo 'Create controller: ' . $fileName;
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
        $fileName = $name . self::CONTROLLER_TYPE . '.php';
        $dir = getcwd() . '/app/Http/Controllers/v1/' . $fileName;

        file_put_contents($dir, $codeCreate, FILE_TEXT);

        return $fileName;

    }

}
