<?php

namespace App\Services\Task;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
{
    public function list(array $data): Collection|LengthAwarePaginator;

    public function create(array $data): Task;

    public function update(array $data, string|int $id): ?Task;

    public function view(string $id): Task;

    public function delete(string $id): bool;
}
