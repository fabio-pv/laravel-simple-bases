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
        $allDataThisModel = from_to_data($this->model);
        foreach ($datas as $key => $data) {
            $fromToData = $allDataThisModel[$key] ?? null;
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
        if(empty($data)){
            return;
        }
        /**
         * @var ModelBase $model
         */
        $model = new $fromToData['model'];
        $model = $model->findByUuid($data);
        if (empty($model)) {
            throw new ModelNotFoundException();
        }
        $this->realProperties[$fromToData['property']] = $model->id;

    }

}
