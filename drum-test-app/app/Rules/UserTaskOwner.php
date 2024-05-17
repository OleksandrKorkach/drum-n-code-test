<?php

namespace App\Rules;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class UserTaskOwner implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $task = Task::find($value);
        if (Auth::id() != $task->user_id) {
            $fail('Permission denied!');
        }
    }
}
