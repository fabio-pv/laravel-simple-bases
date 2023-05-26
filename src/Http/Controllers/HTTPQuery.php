<?php


namespace LaravelSimpleBases\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use LaravelSimpleBases\Exceptions\ValidationException;

const COLUMN_VALUE_DELIMITER = '@';
const JOIN_DELIMITER = '.';

const OPERATOR = [

    'equal' => '=',
    'not_equal' => '!=',
    'greater_than_or_equal_to' => '>=',
    'less_than_or_equal_to' => '<=',
    'like' => 'like',
    'not_like' => 'not like',
    'lt' => '<',
    'gt' => '>',
    'eq' => '=',
    'ne' => '!=',
    'gte' => '>=',
    'lte' => '<=',

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

            $keyAndOperator = explode(COLUMN_VALUE_DELIMITER, key($filter));;

            $key = $keyAndOperator[0];

            if (!array_key_exists($keyAndOperator[1], OPERATOR)) {
                throw new ValidationException(
                    "Operator '" .
                    $keyAndOperator[1] .
                    "' for the filter is not available"
                );
            }

            $operator = OPERATOR[$keyAndOperator[1]];
            $value = array_values($filter)[0];

            // remover or
            if (strpos($key, JOIN_DELIMITER)) {
                $this->whereJoin($key, $operator, $value);
                return;
            }

            $this->retrive = $this->doWhereAuto($this->retrive, $key, $operator, $value);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function doWhereAuto($query, string $column, string $operator, $value = null)
    {
        if ($operator === 'like' || $operator === 'not like') {
            $value = "%$value%";
        }

        if (str_contains($column, 'or:')) {
            $column = str_replace('or:', '', $column);
            return $query->orWhere($column, $operator, $value);
        }

        return $query->where($column, $operator, $value);
    }

    private function whereJoin(string $key, string $operador, $value): void
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
                use ($column, $operador, $value) {
                    return $this->doWhereAuto($query, $column, $operador, $value);
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
