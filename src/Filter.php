<?php

namespace Dfevrier\LaravelFilter;

trait Filter
{

    public function filter($model, $columns)
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
            
        }
    }
}
