<?php

namespace App\DTOs\Task;

use App\Http\Requests\Task\UpdateTaskRequest;

class UpdateTaskDTO
{
    public string $title;
    public ?string $description;
    public int $priority;

    public function __construct(
        string $title,
        ?string $description,
        int $priority,
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
    }

    public static function fromRequest(UpdateTaskRequest $request): UpdateTaskDTO
    {
        return new self(
            $request->input('title'),
            $request->input('description'),
            $request->input('priority'),
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
        ];
    }
}
