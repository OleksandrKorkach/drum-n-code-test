<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TaskRepository
{
    public function getUserTasks(int $userId): Collection|array
    {
        $tasks = Task::with('subtasks')
            ->where('user_id', $userId)
            ->whereNull('task_id')
            ->get();

        $tasks->each->loadSubtasksRecursively();
        return $tasks;
    }

    public function storeTask(array $data)
    {
        return Task::create($data);
    }

    public function setTaskCompletedAt($taskId, Carbon $timestamp): Model|Collection|Builder|array|null
    {
        $task = Task::findOrFail($taskId);
        $task->completed_at = $timestamp;
        $task->save();
        return $task;
    }

    public function destroyTask(string $taskId): void
    {
        Task::destroy($taskId);
    }

    public function updateTask(string $taskId, array $data)
    {
        $task = Task::find($taskId);
        $task->update($data);
        return $task;
    }
}
