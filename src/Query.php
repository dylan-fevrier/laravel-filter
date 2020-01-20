<?php

namespace Dfevrier\LaravelFilter;

class Query
{

    /**
     *  @var string
     */
    private $column;

    /**
     *  @var string
     */
    private $operator = '=';

     /**
     *  @var string
     */
    private $search;

    public function __construct(string $column ,string $search, ?string $operator = null)
    {
        $this->column = $column;
        $this->search = $search;
        if ($operator) {
            $this->operator = $operator;
        }
    }

    /**
     *  @return string|null
     */
    public function getColumn(): ?string
    {
        return $this->column;
    }

    /**
     *  @return string|null
     */
    public function getOperator(): ?string
    {
        return $this->operator;
    }

    /**
     *  @return string|null
     */
    public function getSearch(): ?string
    {
        if ($this->operator === 'like') {
            $this->search = '%' . $this->search . '%';
        }
        return $this->search;
    }
}
