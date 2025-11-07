<?php

use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

// ============================================================================
// User Model Relationships
// ============================================================================

test('users_belong_to_many_organizations', function () {
    $organization = Organization::factory()->create();

    $user = User::factory()->create();
    $user->organizations()->attach($organization);

    expect($user->organizations)->toHaveCount(1);
    expect($organization->users)->toHaveCount(1);
});

test('users_have_many_projects', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();

    $user->projects()->attach($project, ['role' => 'member']);

    expect($user->projects)->toHaveCount(1);
    expect($project->users)->toHaveCount(1);
    expect($user->projects->first()->pivot->role)->toBe('member');
});

// ============================================================================
// Organization Model Relationships
// ============================================================================

test('organizations_belong_to_many_users', function () {
    $user = User::factory()->create();

    $organization = Organization::factory()->create();
    $organization->users()->attach($user);

    expect($organization->users)->toHaveCount(1);
    expect($user->organizations)->toHaveCount(1);
});

test('organizations_have_many_projects', function () {
    $organization = Organization::factory()->create();
    $project = Project::factory()->create(['organization_id' => $organization->id]);

    expect($organization->projects)->toHaveCount(1);
    expect($project->organization->id)->toBe($organization->id);
});

// ============================================================================
// Project Model Relationships
// ============================================================================

test('projects_belong_to_an_organization', function () {
    $organization = Organization::factory()->create();
    $project = Project::factory()->create(['organization_id' => $organization->id]);

    expect($project->organization->id)->toBe($organization->id);
    expect($organization->projects)->toHaveCount(1);
});

test('projects belong_to_many_users', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();

    $project->users()->attach($user);

    expect($project->users)->toHaveCount(1);
    expect($user->projects)->toHaveCount(1);
});
