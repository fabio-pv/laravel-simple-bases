<?php


namespace LaravelSimpleBases\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LaravelSimpleBases\Events\UuidModelEvent;

/**
 * Class ModelBase
 * @package App\Models\v2
 * @property Model $findByUuid
 * @property File $files
 */
abstract class ModelAuthenticatableBase extends Authenticatable
{

    use SoftDeletes;

    protected $dispatchesEvents = [
        'creating' => UuidModelEvent::class
    ];

    /**
     * @param string $uuid
     * @return Model
     */
    public static function findByUuid(string $uuid): Model
    {
        return self::where('uuid', $uuid)->get()->first();
    }

    public function files()
    {
        return $this->hasMany(File::class, 'reference_id')
            ->where('reference', get_class($this));
    }

}
