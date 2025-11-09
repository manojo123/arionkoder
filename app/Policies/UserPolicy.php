<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view all users
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // All authenticated users can view any user
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admins can create users
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Members can only update themselves
        if ($user->hasRole('member')) {
            return $user->id === $model->id;
        }

        // Managers can update themselves and members
        if ($user->hasRole('manager')) {
            return $user->id === $model->id || $model->hasRole('member');
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Managers can delete members (but not themselves or other managers)
        if ($user->hasRole('manager')) {
            return $model->hasRole('member') && $user->id !== $model->id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Managers can restore members
        if ($user->hasRole('manager')) {
            return $model->hasRole('member');
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Managers can permanently delete members
        if ($user->hasRole('manager')) {
            return $model->hasRole('member') && $user->id !== $model->id;
        }

        return false;
    }
}
