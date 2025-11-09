<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Manager can view all tasks in their projects
        if ($user->hasRole('manager')) {
            return true;
        }

        // Member can view tasks assigned to them (handled by query filtering)
        return $user->hasRole('member');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        // Load project relationship if not already loaded
        if (! $task->relationLoaded('project')) {
            $task->load('project');
        }

        $project = $task->project;

        if (! $project) {
            return false;
        }

        // Manager can view all tasks in their projects
        if ($user->hasRole('manager')) {
            return $this->isUserInProject($user, $project);
        }

        // Member can only view tasks assigned to them in projects they have access to
        if ($user->hasRole('member')) {
            return $task->user_id === $user->id && $this->isUserInProject($user, $project);
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only managers can create tasks
        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        // Load project relationship if not already loaded
        if (! $task->relationLoaded('project')) {
            $task->load('project');
        }

        $project = $task->project;

        if (! $project) {
            return false;
        }

        // Manager can update all tasks in their projects
        if ($user->hasRole('manager')) {
            return $this->isUserInProject($user, $project);
        }

        // Member can only update tasks assigned to them
        if ($user->hasRole('member')) {
            return $task->user_id === $user->id && $this->isUserInProject($user, $project);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // Only managers can delete tasks
        if ($user->hasRole('manager')) {
            // Load project relationship if not already loaded
            if (! $task->relationLoaded('project')) {
                $task->load('project');
            }

            $project = $task->project;

            return $project && $this->isUserInProject($user, $project);
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        // Only managers can restore tasks
        if ($user->hasRole('manager')) {
            // Load project relationship if not already loaded
            if (! $task->relationLoaded('project')) {
                $task->load('project');
            }

            $project = $task->project;

            return $project && $this->isUserInProject($user, $project);
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        // Only managers can permanently delete tasks
        if ($user->hasRole('manager')) {
            // Load project relationship if not already loaded
            if (! $task->relationLoaded('project')) {
                $task->load('project');
            }

            $project = $task->project;

            return $project && $this->isUserInProject($user, $project);
        }

        return false;
    }

    /**
     * Check if user is part of the project.
     */
    protected function isUserInProject(User $user, $project): bool
    {
        return $project->users()->where('users.id', $user->id)->exists();
    }
}
