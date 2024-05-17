<?php

namespace App\Http\Controllers;

use App\DTOs\Task\StoreTaskDTO;
use App\DTOs\Task\UpdateTaskDTO;
use App\Http\Requests\Task\DestroyTaskRequest;
use App\Http\Requests\Task\GetTasksRequest;
use App\Http\Requests\Task\SetTaskCompletedRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(GetTasksRequest $request): JsonResponse
    {
        $tasks = $this->taskService->getAuthUserTasks($request->all());
        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $storeTaskDTO = StoreTaskDTO::fromRequest($request);
        $task = $this->taskService->storeTask($storeTaskDTO);

        return response()->json([
            'message' => 'Task created successfully!',
            'task' => $task
        ]);
    }

    public function setTaskCompleted(SetTaskCompletedRequest $request): JsonResponse
    {
        $updatedTask = $this->taskService->setTaskCompleted($request->input('task_id'));

        return response()->json(['message' => 'Task set as completed successfully!', 'task' => $updatedTask]);
    }

    public function destroy(DestroyTaskRequest $request): JsonResponse
    {
        $this->taskService->deleteTask($request->input('task_id'));

        return response()->json(['message' => 'Task deleted!']);
    }

    public function update(UpdateTaskRequest $request, string $taskId): JsonResponse
    {
        $updateTaskDTO = UpdateTaskDTO::fromRequest($request);
        $task = $this->taskService->updateTask($taskId, $updateTaskDTO);
        return response()->json(['message' => 'Task updated!', 'task' => $task]);
    }
}
