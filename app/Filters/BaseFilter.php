<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BaseFilter
{

    protected $query;
    protected $filter;

    public function __construct(Builder $query, array $filter)
    {
        $this->query = $query;
        $this->filter = $filter;
    }

    public function filter()
    {
        foreach($this->filter as $field => $value) {
            $method = $this->getMethodName($field);
            $this->$method($value);
        }

        return $this->query;
    }

    protected function getMethodName($field) {
        return 'filter'.Str::ucfirst(Str::camel($field));
    }

}
