<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

final class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory(100)->create();
    }
}
