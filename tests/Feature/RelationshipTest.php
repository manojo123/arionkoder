<?php

use App\Enums\ProjectUserRole;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskComment;
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

    $user->projects()->attach($project, ['role' => ProjectUserRole::Member->value]);

    expect($user->projects)->toHaveCount(1);
    expect($project->users)->toHaveCount(1);
    expect($user->projects->first()->pivot->role)->toBe(ProjectUserRole::Member->value);
});

test('users_have_many_tasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    expect($user->tasks)->toHaveCount(1);
    expect($task->user->id)->toBe($user->id);
});

test('users_have_many_comments', function () {
    $user = User::factory()->create();
    $comment = TaskComment::factory()->create(['user_id' => $user->id]);

    expect($user->comments)->toHaveCount(1);
    expect($comment->user->id)->toBe($user->id);
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

test('projects_have_many_tasks', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create(['project_id' => $project->id]);

    expect($project->tasks)->toHaveCount(1);
    expect($task->project->id)->toBe($project->id);
});

// ============================================================================
// Task Model Relationships
// ============================================================================

test('tasks_belong_to_a_project', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create(['project_id' => $project->id]);

    expect($task->project->id)->toBe($project->id);
    expect($project->tasks)->toHaveCount(1);
});

test('tasks_belong_to_a_user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    expect($task->user->id)->toBe($user->id);
    expect($user->tasks)->toHaveCount(1);
});

test('tasks_have_a_created_by_user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['created_by' => $user->id]);

    expect($task->createdBy->id)->toBe($user->id);
});

test('tasks_have_a_modified_by_user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['modified_by' => $user->id]);

    expect($task->modifiedBy->id)->toBe($user->id);
});

test('tasks_have_many_comments', function () {
    $task = Task::factory()->create();
    $comment = TaskComment::factory()->create(['task_id' => $task->id]);

    expect($task->comments)->toHaveCount(1);
    expect($comment->task->id)->toBe($task->id);
});

test('tasks_have_a_parent_task', function () {
    $parentTask = Task::factory()->create();
    $childTask = Task::factory()->create(['task_id' => $parentTask->id]);

    expect($childTask->parentTask->id)->toBe($parentTask->id);
    expect($parentTask->childTasks)->toHaveCount(1);
});

test('tasks_have_many_child_tasks', function () {
    $parentTask = Task::factory()->create();
    $childTask = Task::factory()->create(['task_id' => $parentTask->id]);

    expect($parentTask->childTasks)->toHaveCount(1);
    expect($childTask->parentTask->id)->toBe($parentTask->id);
});

// ============================================================================
// Task Comment Model Relationships
// ============================================================================

test('task_comments_belong_to_a_task', function () {
    $task = Task::factory()->create();
    $comment = TaskComment::factory()->create(['task_id' => $task->id]);

    expect($comment->task->id)->toBe($task->id);
    expect($task->comments)->toHaveCount(1);
});

test('task_comments_belong_to_a_user', function () {
    $user = User::factory()->create();
    $comment = TaskComment::factory()->create(['user_id' => $user->id]);

    expect($comment->user->id)->toBe($user->id);
    expect($user->comments)->toHaveCount(1);
});
