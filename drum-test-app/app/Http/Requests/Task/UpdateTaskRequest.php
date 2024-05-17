<?php

namespace App\Http\Requests\Task;

use App\Rules\UserTaskOwner;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'task_id' => $this->route('taskId')
        ]);
    }

    public function rules(): array
    {
        return [
            'task_id' => [
                'required',
                'exists:tasks,id',
                new UserTaskOwner(),
            ],
            'title' => 'required|string|max:255',
            'description' => 'string',
            'priority' => 'required|integer|max:5|min:1',
        ];
    }
}
