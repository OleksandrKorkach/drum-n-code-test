<?php

namespace App\Services;

use App\DTOs\Task\StoreTaskDTO;
use App\DTOs\Task\UpdateTaskDTO;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAuthUserTasks(array $filters): Collection|array
    {
        $userId = Auth::id();
        return $this->taskRepository->getUserTasks($userId, $filters);
    }

    public function storeTask(StoreTaskDTO $storeTaskDTO)
    {
        return $this->taskRepository->storeTask($storeTaskDTO->toArray());
    }

    public function setTaskCompleted($taskId): Model|Collection|Builder|array|null
    {
        return $this->taskRepository->setTaskCompletedAt($taskId, now());
    }

    public function deleteTask(string $taskId): void
    {
        $this->taskRepository->destroyTask($taskId);
    }

    public function updateTask(string $taskId, UpdateTaskDTO $updateTaskDTO)
    {
        return $this->taskRepository->updateTask($taskId, $updateTaskDTO->toArray());
    }


}
