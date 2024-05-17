<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TaskRepository
{
    public function getUserTasks(int $userId, array $filters): Collection|array
    {
        $query = Task::with('subtasks')
            ->where('user_id', $userId)
            ->whereNull('task_id');

        $query = $this->applyStatusFilter($query, $filters);
        $query = $this->applyPriorityFilter($query, $filters);
        $query = $this->applySearchFilter($query, $filters);
        $query = $this->applySort($query, $filters);

        $tasks = $query->get();
        $tasks->each->loadSubtasksRecursively();

        return $tasks;
    }

    private function applyStatusFilter(Builder $query, array $filters): Builder
    {
        if (isset($filters['status'])) {
            $query->where('status_id', $filters['status']);
        }
        return $query;
    }

    private function applyPriorityFilter(Builder $query, array $filters): Builder
    {
        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        return $query;
    }

    private function applySearchFilter(Builder $query, array $filters): Builder
    {
        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }
        return $query;
    }

    private function applySort(Builder $query, array $filters): Builder
    {
        if (isset($filters['sort'])) {
            foreach (explode(',', $filters['sort']) as $sort) {
                [$field, $direction] = explode(' ', trim($sort));
                $query->orderBy($field, $direction);
            }
        }
        return $query;
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
