<?php

namespace LaravelSimpleBases\Transformers;

use LaravelSimpleBases\Models\File;
use LaravelSimpleBases\Utils\FileInterceptorUtil;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    /**
     * @param File $file
     * @return array
     */
    public function transform(File $file)
    {
        return [
            'uuid' => $file->uuid,
            'file' => $file->file,
            'extension' => $file->extension,
            'name' => $file->name,
            'url' => FileInterceptorUtil::makeUrl(
                $file->reference,
                $file->file,
                $file->extension
            ),
        ];
    }
}
