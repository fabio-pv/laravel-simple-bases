<?php


namespace LaravelSimpleBases\Services;


use Illuminate\Database\Eloquent\Model;
use LaravelSimpleBases\Exceptions\ModelNotFoundException;

class BaseService
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseService constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     * @throws \Exception
     */
    public function retriveAll(): Model
    {
        try {

            $collection = $this->model;

        } catch (\Exception $e) {
            throw $e;
        }

        return $collection;
    }

    /**
     * @param $uuid
     * @throws \Exception
     */
    public function searchByUuid($uuid): Model
    {
        try {

            $model = $this->model->findByUuid($uuid);
            if (empty($model)) {
                throw new ModelNotFoundException();
            }

        } catch (\Exception $e) {
            throw $e;
        }

        return $model;

    }

    /**
     * @param $data
     */
    public function save($data)
    {
        try {

            $model = $this->model->create($data);

        } catch (\Exception $e) {
            throw $e;
        }

        return $model;

    }

    /**
     * @param $data
     * @param $uuid
     * @return mixed
     * @throws \Exception
     */
    public function change($data, $uuid)
    {
        try {

            $model = $this->model->findByUuid($uuid);
            if (empty($model)) {
                throw new ModelNotFoundException();
            }

            $model = $model->update($data);

        } catch (\Exception $e) {
            throw $e;
        }

        return $model;

    }

    /**
     * @param $uuid
     * @return mixed
     * @throws \Exception
     */
    public function remove($uuid)
    {
        try {

            $model = $this->model->findByUuid($uuid);
            if (empty($model)) {
                throw new ModelNotFoundException();
            }

            $model->delete();

        } catch (\Exception $e) {
            throw $e;
        }

        return $model;

    }

}
