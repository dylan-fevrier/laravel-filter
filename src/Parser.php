<?php

namespace Dfevrier\LaravelFilter;

class Parser
{

    public static function parse(array $args, array $search): array
    {
        $queries = [];
        foreach ($args as $key => $value) {
            if (is_string($key) && is_array($value)) {
                if (!isset($search[$key])) {
                    continue;
                }
                if (!isset($value['operator'])) {
                    $queries[] = new Query($key, $search[$key]);
                } else {
                    $queries[] = new Query($key, $search[$key], $value['operator']);
                }
            } else if (is_string($key)) {
                if (!isset($search[$key])) {
                    continue;
                }
                $queries[] = new Query($key, $search[$key], $value);
            } else {
                if (!isset($search[$value])) {
                    continue;
                }
                $queries[] = new Query($value, $search[$value]);
            }
        }
        return $queries;
    }
}
