<?php

namespace App\Http\Filters\V1;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
  protected $request;
  protected $builder;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function filter($arr)
  {
    foreach ($arr as $key => $value) {
      if (method_exists($this, $key)) {
        $this->$key($value);
      }
    }

    return $this->builder;
  }

  public function apply(Builder $builder)
  {
    $this->builder = $builder;

    foreach ($this->request->all() as $filter => $value) {
      if (method_exists($this, $filter)) {
        $builder = $this->$filter($builder, $value);
      }
    }

    return $builder;
  }
}
