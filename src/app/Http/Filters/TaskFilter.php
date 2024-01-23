<?php

namespace App\Http\Filters;

use App\Utils\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class TaskFilter extends AbstractFilter
{
    public const NAME = 'name';

    public const DESC = 'desc';

    public function name(Builder $builder, string $value): void
    {
        $builder->where('name', 'LIKE', '%'.$value.'%');
    }

    public function desc(Builder $builder, string $value): void
    {
        $builder->where('desc', 'LIKE', '%'.$value.'%');
    }

    #[\Override]
    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::DESC => [$this, 'desc'],
            self::SORT => [$this, 'sort'],
        ];
    }
}
