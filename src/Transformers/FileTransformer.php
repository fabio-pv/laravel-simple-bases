<?php

namespace LaravelSimpleBases\Transformers;

use LaravelSimpleBases\Models\File;
use LaravelSimpleBases\Utils\FileInterceptorUtil;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

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
            'url' => FileInterceptorUtil::makeUrl(
                $file->reference,
                $file->file,
                $file->extension
            ),
        ];
    }
}
