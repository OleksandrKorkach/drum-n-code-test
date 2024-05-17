<?php

namespace App\Rules;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SubtasksCompleted implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $task = Task::with('subtasks')->find($value);

        if (!$task) {
            $fail('The task does not exist.');
            return;
        }

        foreach ($task->subtasks as $subtask) {
            if (empty($subtask->completed_at)) {
                $fail('All subtasks must be completed first.');
                return;
            }
        }
    }
}
