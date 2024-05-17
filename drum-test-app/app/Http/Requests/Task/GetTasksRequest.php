<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class GetTasksRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'nullable|integer|exists:task_statuses,id',
            'priority' => 'nullable|integer|min:1|max:5',
            'search' => 'nullable|string',
            'sort' => 'nullable|string',
        ];
    }
}
