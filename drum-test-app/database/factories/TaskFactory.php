<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'priority' => $this->faker->numberBetween(1, 5),
            'status_id' => $this->faker->numberBetween(1, 2),
            'user_id' => User::factory(),
            'task_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
