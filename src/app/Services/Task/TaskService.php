<?php

namespace App\Services\Task;

use App\Exceptions\TaskException;
use App\Http\Filters\TaskFilter;
use App\Jobs\TaskListAddCacheJob;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class TaskService implements TaskServiceInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws TaskException
     */
    public function list(array $data): Collection|LengthAwarePaginator
    {
        $page = request()->get('page', 1);
        $key = (new Task())->getTable().':page:'.$page;

        if (! isset($data['sort'])) {
            $data['sort']['id'] = 'desc';
        }

        $key .= ':hash:'.md5(json_encode($data, JSON_THROW_ON_ERROR));

        $collection = Cache::get($key, static function () use ($data) {
            $perPage = (int) request()->get('per_page', 20);
            $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);
            $builder = Task::filter($filter);

            if ($perPage === 0) {
                return $builder->get();
            }

            return $builder->paginate($perPage);
        });

        if ($collection->count() > 0) {
            Cache::put($key, $collection, now()->addMinutes(10));
            TaskListAddCacheJob::dispatch($collection);

            return $collection;
        }

        throw new TaskException('Список задач пуст', 500);
    }

    /**
     * @throws TaskException
     */
    public function create(array $data): Task
    {
        $task = Task::query()->create($data);

        if ($task) {
            $key = (new Task())->getTable().':id:'.$task->id;
            Cache::put($key, $task, now()->addMinutes(10));

            return $task;
        }

        throw new TaskException('Не удалось создать новую задачу', 500);
    }

    /**
     * @throws TaskException
     */
    public function update(array $data, string|int $id): ?Task
    {
        $task = $this->view($id);

        if ($task->update($data)) {
            $key = (new Task())->getTable().':id:'.$id;
            Cache::put($key, $task, now()->addMinutes(10));

            return $task;
        }

        throw new TaskException('Не удалось обновить задачу id='.$id, 500);
    }

    public function view(string $id): Task
    {
        $key = (new Task())->getTable().':id:'.$id;

        return Cache::remember($key, now()->addMinutes(10), static function () use ($id) {
            $task = Task::query()->find($id);

            if ($task) {
                return $task;
            }

            throw new TaskException('Страница не найдена', 404);
        });
    }

    /**
     * @throws TaskException
     */
    public function delete(string $id): bool
    {
        $task = $this->view($id);

        if ($task->delete()) {
            $key = (new Task())->getTable().':id:'.$id;
            Cache::delete($key);

            return true;
        }

        throw new TaskException('Не удалось удалить задачу id='.$id, 500);
    }
}
