<?php


namespace LaravelSimpleBases\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use LaravelSimpleBases\Exceptions\ValidationException;

const COLUMN_VALUE_DELIMITER = '@';
const JOIN_DELIMITER = '.';
const TYPE_WHERE_DELIMITER = ':';

const OPERATOR = [

    'equal' => '=',
    'not_equal' => '!=',
    'greater_than_or_equal_to' => '>=',
    'less_than_or_equal_to' => '<=',
    'like' => 'like',
    'lt' => '<',
    'gt' => '>',
    'eq' => '=',
    'ne' => '!=',
    'gte' => '>=',
    'lte' => '<=',
    'not_like' => 'not like',

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

        try {

            $keyOperatorWhere = explode(COLUMN_VALUE_DELIMITER, key($filter));
            $keyOperatorWhere[2] = explode(TYPE_WHERE_DELIMITER, $keyOperatorWhere[1])[1];
            $keyOperatorWhere[1] = explode(TYPE_WHERE_DELIMITER, $keyOperatorWhere[1])[0];

            $key = $keyOperatorWhere[0];

            if (!array_key_exists($keyOperatorWhere[1], OPERATOR)) {
                throw new ValidationException(
                    "Operator '" .
                    $keyOperatorWhere[1] .
                    "' for the filter is not available"
                );
            }

            $operator = OPERATOR[$keyOperatorWhere[1]];
            $type = $keyOperatorWhere[2];
            $value = array_values($filter)[0];

            if (strpos($key, JOIN_DELIMITER)) {
                $this->whereJoin($key, $operator, $value, $type);
                return;
            }

            $this->retrive = $this->doWhereAuto($this->retrive, $key, $operator, $value, $type);

        } catch (\Exception $e) {
            throw $e;
        }

    }

    private function doWhereAuto($query, string $column, string $operator, $value = null, string $type)
    {

        if ($operator === 'like' || $operator === 'not like') {
            $value = "%$value%";
        }

        if ($type === 'and') {
            $query = $query->where($column, $operator, $value);
        }

        if($type === 'or') {
            $query = $query->orWhere($column, $operator, $value);
        }

        return $query;

    }

    private function whereJoin(string $key, string $operador, $value, string $type): void
    {

        $relation = explode('.', $key);
        $column = $relation[(count($relation) - 1)];
        array_pop($relation);
        $relation = $this->makeRelationForJoin($relation);

        if ($value === null) {

            $this->retrive = $this->retrive
                ->doesntHave($relation);
            return;
        }

        $this->retrive = $this->retrive
            ->whereHas($relation,
                function (Builder $query)
                use ($column, $operador, $value, $type) {

                    return $this->doWhereAuto($query, $column, $operador, $value, $type);

                });
    }

    private function makeRelationForJoin(array $relations): string
    {
        $relationString = '';
        foreach ($relations as $relation) {
            if (strpos($relation, '_') === false) {
                $relationString .= $relation . '.';
                continue;
            }

            $relation = str_replace('_', ' ', $relation);
            $relation = ucwords($relation);
            $relation = str_replace(' ', '', $relation);
            $relation = lcfirst($relation);

            $relationString .= $relation . '.';

        }

        return substr($relationString, 0, -1);

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

    private function makeOrder($orderArray)
    {
        foreach ($orderArray as $column => $direction) {
            $this->retrive = $this->retrive->orderBy($column, $direction);
        }
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
