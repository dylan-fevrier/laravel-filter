<?php

namespace Dfevrier\LaravelFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait Filter
{

    /**
     * [filter description]
     * @param  Model   $model   [description]
     * @param  array   $columns [description]
     * @param  Request $request [description]
     * @return Builder            [description]
     */
    public function filter(Model $model, array $columns, Request $request): Builder
    {
        foreach ($columns as $key => $value) {
            if (is_array($value)) {
                $columnName = $key;
            } else {
                $columnName = $value;
            }
            if (!$request->has($columnName) || $request->get($columnName) === NULL) {
                continue;
            }
            if (is_array($value) && isset($value['operator'])) {
                $model = $this->addFilter($model, $columnName, $request->get($columnName), $value['operator']);
            } else {
                $model = $this->addFilter($model, $columnName, $request->get($columnName));
            }
        }
        return $model;
    }

    /**
     * Add a filter to query.
     * @param  Model  $model    [description]
     * @param  string $column   [description]
     * @param  string $search   [description]
     * @param  string $operator [description]
     */
    private function addFilter(Model $model, string $column, string $search, ?string $operator = '=')
    {
        if ($operator == 'like') {
            $search = '%' . $search . '%';
        }
        $model = $model->where($column, $operator, $search);
        return $model;
    }
}
