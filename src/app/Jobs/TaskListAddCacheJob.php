<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

final class TaskListAddCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Collection|LengthAwarePaginator $tasks;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection|LengthAwarePaginator $tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tasks->each(static function (Task $task) {
            $key = $task->getTable().':id:'.$task->id;
            Cache::put($key, $task, now()->addMinutes(10));
        });
    }
}
