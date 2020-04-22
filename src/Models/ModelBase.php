<?php


namespace LaravelSimpleBases\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ModelBase
 * @package App\Models\v2
 * @property Model $findByUuid
 */
abstract class ModelBase extends Model
{

    use SoftDeletes;

    protected $dispatchesEvents = [

    ];

    /**
     * @param string $uuid
     * @return Model
     */
    public static function findByUuid(string $uuid): Model
    {
        return self::where('uuid', $uuid)->get()->first();
    }


}