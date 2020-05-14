<?php


namespace LaravelSimpleBases\Services;


use Illuminate\Database\Eloquent\Model;
use LaravelSimpleBases\Exceptions\ModelNotFoundException;

class BaseService
{

    use ComplexQueryService;
    use FileInterceptor;

    /**
     * @var Model
     */
    protected $model;

    protected $lastRealData = [];

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
    public function retriveAll()
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
    public function searchByUuid($uuid)
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

            $this->lastRealData = $this->makeRealData($data);
            $this->model = $this->model->create($this->lastRealData);
            $this->interceptFile();

        } catch (\Exception $e) {
            throw $e;
        }

        return $this->model;

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

            $this->lastRealData = $this->makeRealData($data);
            $model->update($this->lastRealData);

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
