<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Users and managers can view organizations they belong to (filtered in query)
        return $user->hasRole('manager') || $user->hasRole('member');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Organization $organization): bool
    {
        // Users and managers can only view organizations they belong to
        return $this->isUserInOrganization($user, $organization);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admins can create organizations
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organization $organization): bool
    {
        // Users and managers can only update organizations they belong to
        return $this->isUserInOrganization($user, $organization);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Organization $organization): bool
    {
        // Only admins can delete organizations
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Organization $organization): bool
    {
        // Only admins can restore organizations
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Organization $organization): bool
    {
        // Only admins can permanently delete organizations
        return false;
    }

    /**
     * Check if user belongs to the organization.
     */
    protected function isUserInOrganization(User $user, Organization $organization): bool
    {
        return $organization->users()->where('users.id', $user->id)->exists();
    }
}
