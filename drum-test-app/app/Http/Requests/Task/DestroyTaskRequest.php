<?php

namespace App\Http\Requests\Task;

use App\Rules\TaskNotCompleted;
use App\Rules\UserTaskOwner;
use Illuminate\Foundation\Http\FormRequest;

class DestroyTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'task_id' => [
                'required',
                new UserTaskOwner(),
                new TaskNotCompleted(),
            ]
        ];
    }

}
