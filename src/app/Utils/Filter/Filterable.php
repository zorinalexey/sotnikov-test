<?php

namespace App\Utils\Filter;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    final public function scopeFilter(Builder $builder, FilterInterface $filter): Builder
    {
        $filter->apply($builder);

        return $builder;
    }
}
