<?php

namespace App\Http\Requests\Task;

use App\Rules\SubtasksCompleted;
use App\Rules\UserTaskOwner;
use Illuminate\Foundation\Http\FormRequest;

class SetTaskCompletedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'task_id' => [
                new UserTaskOwner(),
                new SubtasksCompleted(),
                'required'
            ],
            'completed_at' => [
                'required',
            ],
        ];
    }
}
