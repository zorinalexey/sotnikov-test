<?php

namespace App\Utils\Filter;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements FilterInterface
{
    private array $queryParams = [];

    final public const SORT = 'sort';

    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    final public function apply(Builder $builder): void
    {
        $this->before($builder);

        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                $callback($builder, $this->queryParams[$name]);
            }
        }

        $this->after($builder);
    }

    protected function before(Builder $builder): void
    {
    }

    abstract protected function getCallbacks(): array;

    protected function after(Builder $builder): void
    {
    }

    final protected function getQueryParam(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }

    final protected function removeQueryParam(string ...$keys): self
    {
        foreach ($keys as $key) {
            unset($this->queryParams[$key]);
        }

        return $this;
    }

    final public function sort(Builder $builder, array $sort): void
    {
        foreach ($sort as $field => $value) {
            $builder->orderBy($field, $this->getSortValue($value));
        }
    }

    private function getSortValue(mixed $value): string
    {
        $value = mb_strtoupper($value);

        if ($value === 'ASC') {
            return $value;
        }

        return 'DESC';
    }
}
