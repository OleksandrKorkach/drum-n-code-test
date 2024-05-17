<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status_id',
        'user_id',
        'task_id',
        'completed_at',
        'created_at',
        'updated_at',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parentTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'task_id');
    }

    public function loadSubtasksRecursively(): void
    {
        $this->load('subtasks');
        $this->subtasks->each->loadSubtasksRecursively();
    }
}
