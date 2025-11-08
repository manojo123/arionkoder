<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskComment extends Model
{
    /** @use HasFactory<\Database\Factories\TaskCommentFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
    ];

    protected static function booted()
    {
        static::creating(function ($taskComment) {
            if (!$taskComment->user_id) {
                $taskComment->user_id = auth()->id();
            }
        });
    }


    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
