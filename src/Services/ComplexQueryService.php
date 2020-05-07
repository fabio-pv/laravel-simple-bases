<?php


namespace LaravelSimpleBases\Services;


use LaravelSimpleBases\Exceptions\ModelNotFoundException;
use LaravelSimpleBases\Models\ModelBase;

trait ComplexQueryService
{
    private $realProperties = [];

    protected function makeRealData(array $datas = [])
    {
        $this->realProperties = [];
        foreach ($datas as $key => $data) {
            $fromToData = from_to_data($key);
            if (empty($fromToData)) {
                continue;
            }

            $this->getRealData($fromToData, $data);
            unset($datas[$key]);
        }

        $datas = array_merge($datas, $this->realProperties);

        return $datas;

    }

    private function getRealData($fromToData, $data)
    {
        /**
         * @var ModelBase $model
         */
        $model = new $fromToData['model'];
        $model = $model->findByUuid($data);
        if(empty($model)){
            throw new ModelNotFoundException();
        }
        $this->realProperties[$fromToData['property']] = $model->id;

    }

}
