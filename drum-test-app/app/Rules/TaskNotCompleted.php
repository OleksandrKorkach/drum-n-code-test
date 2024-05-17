<?php

namespace App\Rules;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TaskNotCompleted implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $task = Task::find($value);

        if (!empty($task->completed_at)) {
            $fail("'You can't delete completed tasks.");
        }
    }
}
