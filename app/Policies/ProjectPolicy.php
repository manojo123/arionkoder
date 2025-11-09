<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Manager can view all projects
        if ($user->hasRole('manager')) {
            return true;
        }

        // Member can view projects they're part of (handled by query filtering)
        return $user->hasRole('member');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // Manager can view all projects
        if ($user->hasRole('manager')) {
            return true;
        }

        // Member can only view projects they're part of
        if ($user->hasRole('member')) {
            return $this->isUserInProject($user, $project);
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only managers can create projects
        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Manager can update all projects
        if ($user->hasRole('manager')) {
            return true;
        }

        // Members cannot update projects
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        // Only managers can delete projects
        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        // Only managers can restore projects
        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        // Only managers can permanently delete projects
        return $user->hasRole('manager');
    }

    /**
     * Check if user is part of the project.
     */
    protected function isUserInProject(User $user, Project $project): bool
    {
        return $project->users()->where('users.id', $user->id)->exists();
    }
}
