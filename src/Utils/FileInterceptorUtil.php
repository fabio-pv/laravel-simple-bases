<?php


namespace LaravelSimpleBases\Utils;


class FileInterceptorUtil
{
    static function getSaveLocation($model)
    {
        $array = explode('\\', get_class($model));
        $lastIndex = array_key_last(explode('\\', get_class($model)));

        return 'files/' . strtolower($array[$lastIndex]);

    }

    static function makeUrl($model, $file, $extension)
    {
        $array = explode('\\', $model);
        $lastIndex = array_key_last(explode('\\', $model));

        return config('filesystems.bucket_url', config('app.url'))
	    . '/files/'
            . strtolower($array[$lastIndex])
            . '/'
            . $file
            . $extension;
    }
}
