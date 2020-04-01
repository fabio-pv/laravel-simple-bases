<?php


namespace LaravelSimpleBases\Http\Controllers;

const DELIMITER = '@';
const OPERATOR = [
    'equal' => '=',
    'not_equal' => '!=',
    'greater_than_or_equal_to' => '>=',
    'less_than_or_equal_to' => '<='
];

const PAGINATE_DEFAULT = 10;

trait HTTPQuery
{

    public function filter()
    {

        $filters = request()->get('filters');
        if (empty($filters)) {
            return $this->retrive;
        }

        foreach ($filters as $filter) {

            $this->makeFilter($filter);
        }
        return $this->retrive;
    }

    private function makeFilter($filter)
    {

        $keyAndOperator = explode(DELIMITER, key($filter));;

        $key = $keyAndOperator[0];
        $operator = OPERATOR[$keyAndOperator[1]];
        $value = array_values($filter)[0];

        $this->retrive = $this->retrive->where($key, $operator, $value);

    }

    public function order()
    {
        $order = request()->get('order');
        if (empty($order)) {
            return $this->retrive;
        }

        $this->makeOrder($order);

        return $this->retrive;

    }

    private function makeOrder($order)
    {

        $key = key($order);
        $value = array_values($order)[0];

        $this->retrive = $this->retrive->orderBy($key, $value);

    }

    public function paginate()
    {
        $paginate = request()->get('paginate');
        if (empty($paginate)) {
            return $this->retrive = $this->retrive->paginate(PAGINATE_DEFAULT);
        }

        if ($paginate === 'false') {
            return $this->retrive = $this->retrive->get();
        }

        return $this->retrive = $this->retrive->paginate($paginate);

    }

}
