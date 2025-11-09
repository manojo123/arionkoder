<?php

use App\Enums\ProjectUserRole;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('project_can_have_multiple_users_with_different_roles', function () {
    $manager = User::factory()->create();
    $member = User::factory()->create();
    $project = Project::factory()->create();

    $project->users()->attach($manager, ['role' => ProjectUserRole::Manager->value]);
    $project->users()->attach($member, ['role' => ProjectUserRole::Member->value]);
    expect($project->users)->toHaveCount(2);

    $projectManager = $project->manager();
    expect($projectManager->id)->toBe($manager->id);

    expect($project->users->where('id', $member->id)->first()->pivot->role)->toBe(ProjectUserRole::Member->value);
});
