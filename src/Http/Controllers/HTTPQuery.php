<?php


namespace LaravelSimpleBases\Http\Controllers;

const DELIMITER = '@';
const OPERATOR = [
    'equal' => '=',
    'not_equal' => '!=',
    'greater_than_or_equal_to' => '>=',
    'less_than_or_equal_to' => '<=',
    'like' => 'like'
];

const PAGINATE_DEFAULT = 10;

trait HTTPQuery
{

    private $joinFilters = [];

    public function filter()
    {

        $filters = request()->get('filters');
        if (empty($filters)) {
            return $this->retrive;
        }

        foreach ($filters as $filter) {

            $this->makeFilter($filter);
        }

        foreach ($this->joinFilters as $filter) {
            $this->makeFilterForJoin($filter);
        }

        return $this->retrive;
    }

    private function makeFilter($filter)
    {

        $keyAndOperator = explode(DELIMITER, key($filter));;

        $key = $keyAndOperator[0];
        $operator = OPERATOR[$keyAndOperator[1]];
        $value = array_values($filter)[0];

        if (strpos($key, '.') !== false) {
            $this->whereJoin($key, $operator, $value);
            return;
        }

        if ($operator === 'like') {
            $this->whereLike($key, $operator, $value);
            return;
        }

        $this->whereCommon($key, $operator, $value);

    }

    private function makeFilterForJoin($filter)
    {
        $key = $filter['key'];
        $operator = $filter['operator'];
        $value = $filter['value'];

        if ($operator === 'like') {
            $this->whereLike($key, $operator, $value);
            return;
        }

        $this->whereCommon($key, $operator, $value);

    }

    private function whereCommon($key, $operator, $value): void
    {
        $this->retrive = $this->retrive->where($key, $operator, $value);
    }

    private function whereLike($key, $operator, $value): void
    {
        $this->retrive = $this->retrive->where($key, $operator, "%$value%");
    }

    private function whereJoin($key, $operator, $value): void
    {
        $explode = explode('.', $key);
        $column = $explode[(count($explode) - 1)];
        unset($explode[(count($explode) - 1)]);
        dd($explode);
        foreach ($explode as $table) {

            $relatedTable = $this->makeNameRelatedTable($table);
            $foreign = $this->makeNameForeignKeyTable($table);
            $relatedColumn = $this->makeNameReleatedColumnCompareTable($relatedTable);

            $this->retrive = $this->retrive
                ->join(
                    $relatedTable,
                    $foreign,
                    $operator,
                    $relatedColumn
                );

            $this->joinFilters[] = [
                'key' => $this->makeNameColumnForFilter($relatedTable, $column),
                'operator' => $operator,
                'value' => $value
            ];

        }
    }

    private function makeNameColumnForFilter(string $related, string $column): string
    {
        return $related . '.' . $column;
    }

    private function makeNameReleatedColumnCompareTable(string $related): string
    {
        return $related . '.id';
    }

    private function makeNameForeignKeyTable(string $name): string
    {
        $foreign = $this->model->getTable() . '.' . $name . '_id';
        return $foreign;
    }

    private function makeNameRelatedTable(string $nameRaw): string
    {
        if (substr($nameRaw, -1) === 's') {
            return $nameRaw;
        }

        return $nameRaw . 's';
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
