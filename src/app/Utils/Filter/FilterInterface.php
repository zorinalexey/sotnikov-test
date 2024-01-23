<?php

namespace App\Utils\Filter;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function apply(Builder $builder): void;
}
