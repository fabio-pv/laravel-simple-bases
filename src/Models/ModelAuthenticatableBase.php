<?php


namespace LaravelSimpleBases\Models;


use App\Transformers\v1\UserRoleTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LaravelSimpleBases\Events\UuidModelEvent;
use LaravelSimpleBases\Exceptions\ModelNotFoundException;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class ModelBase
 * @package App\Models\v2
 * @property Model $findByUuid
 * @property File $files
 */
abstract class ModelAuthenticatableBase extends Authenticatable implements JWTSubject
{

    use SoftDeletes;

    protected $dispatchesEvents = [
        'creating' => UuidModelEvent::class
    ];

    /**
     * @param string $uuid
     * @return Model
     */
    public static function findByUuid(string $uuid, bool $withModelNotFound = false)
    {
        $model = self::where('uuid', $uuid)->get()->first();

        if ($withModelNotFound === true and empty($model)) {
            throw new ModelNotFoundException();
        }

        return $model;

    }

    public function files()
    {
        return $this->hasMany(File::class, 'reference_id')
            ->where('reference', get_class($this));
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

}
