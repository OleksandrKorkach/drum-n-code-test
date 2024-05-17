<?php

namespace App\DTOs\Task;

use App\Http\Requests\Task\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskDTO
{
    public string $title;
    public ?string $description;
    public int $priority;
    public int $status_id;
    public int $user_id;
    public ?int $task_id;
    public ?string $completed_at;

    public function __construct(
        string $title,
        ?string $description,
        int $priority,
        int $status_id,
        int $user_id,
        ?int $task_id,
        ?string $completed_at
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->status_id = $status_id;
        $this->user_id = $user_id;
        $this->task_id = $task_id;
        $this->completed_at = $completed_at;
    }

    public static function fromRequest(StoreTaskRequest $request): StoreTaskDTO
    {
        return new self(
            $request->input('title'),
            $request->input('description'),
            $request->input('priority'),
            $request->input('status_id'),
            Auth::id(),
            $request->input('task_id'),
            $request->input('completed_at')
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'task_id' => $this->task_id,
            'completed_at' => $this->completed_at,
        ];
    }
}
