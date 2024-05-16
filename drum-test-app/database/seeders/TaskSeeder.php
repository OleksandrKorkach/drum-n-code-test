<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::inRandomOrder()->take(5)->get();

        $status = TaskStatus::find(1);

        $users->each(function ($user) use ($status) {
            $mainTasks = Task::factory(3)->create([
                'user_id' => $user->id,
                'status_id' => $status->id,
            ]);

            $mainTasks->each(function ($mainTask) use ($user, $status) {
                $subTasks = Task::factory(2)->create([
                    'user_id' => $user->id,
                    'status_id' => $status->id,
                    'task_id' => $mainTask->id,
                ]);

                $subTasks->each(function ($subTask) use ($user, $status) {
                    Task::factory()->create([
                        'user_id' => $user->id,
                        'status_id' => $status->id,
                        'task_id' => $subTask->id,
                    ]);
                });
            });
        });
    }
}
