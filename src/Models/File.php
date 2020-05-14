<?php

namespace LaravelSimpleBases\Models;

use LaravelSimpleBases\Models\ModelBase;

/**
 * @property integer $id
 * @property string $uuid
 * @property string $file
 * @property string $extension
 * @property integer $reference_id
 * @property string $reference
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
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
    protected $fillable = ['uuid', 'file', 'extension', 'reference_id', 'reference', 'created_at', 'updated_at', 'deleted_at'];

}
