<?php

namespace LaravelSimpleBases\Transformers;

use LaravelSimpleBases\Models\File;
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
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(File $file)
    {
        return [
            'uuid' => $file->uuid,
            'file' => $file->file,
            'extension' => $file->extension,
            'url' => config('app.url')
                .  '/v1/file'
                . config('model_with_file')[$file->reference]['save_location']
                . '/'
            . $file->file
            . $file->extension
        ];
    }
}
