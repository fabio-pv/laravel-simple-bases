<?php

namespace LaravelSimpleBases\Models;

use LaravelSimpleBases\Models\ModelBase;
use LaravelSimpleBases\Utils\FileInterceptorUtil;

/**
 * @property integer $id
 * @property string $uuid
 * @property string $file
 * @property string $extension
 * @property integer $reference_id
 * @property string $reference
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $getUrl
 */
class File extends ModelBase
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'file',
        'extension',
        'reference_id',
        'reference',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return string
     */
    public function getUrl()
    {
        return FileInterceptorUtil::makeUrl(
            $this->reference,
            $this->file,
            $this->extension
        );
    }

}
