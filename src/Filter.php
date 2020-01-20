<?php

namespace Dfevrier\LaravelFilter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait Filter
{

    /**
     * Filter.
     * @param  Model   $model   [description]
     * @param  array   $columns [description]
     * @param  Request $request [description]
     * @return Model            [description]
     */
    public function filter(Model $model, array $columns, Request $request)
    {
        $queries = Parser::parse($columns, $request->all());
        foreach ($queries as $query) {
            $model = $model->where(
                $query->getColumn(),
                $query->getOperator(),
                $query->getSearch()
            );
        }
        return $model;
    }
}
