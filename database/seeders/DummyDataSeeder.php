<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Enums\ProjectUserRole;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::create([
            'name' => 'Arionkoder',
            'email' => 'sac@arionkoder.com',
            'address' => '123 Main St, Anytown, USA',
            'phone' => '1234567890',
            'description' => 'Arionkoder description',
        ]);

        $project = $organization->projects()->create([
            'title' => 'Project Dev',
            'description' => 'Project dev description',
            'start_date' => '2025-11-06',
            'end_date' => '2025-11-10',
            'status' => ProjectStatus::Planning->value,
        ]);

        $task = $project->tasks()->create([
            'title' => 'AK-0001 - Finish Script',
            'user_id' => User::role('member')->first()->id,
            'description' => 'We need to finish the script for the project',
            'priority' => TaskPriority::High->value,
            'status' => TaskStatus::ToDo->value,
            'due_date' => '2025-11-10',
            'created_by' => User::role('admin')->first()->id,
            'modified_by' => User::role('admin')->first()->id,
        ]);

        $task->childTasks()->create([
            'user_id' => User::role('member')->first()->id,
            'project_id' => $project->id,
            'title' => 'AK-0002 - My Child Task',
            'description' => 'I am a child task of the parent task AK-0001',
            'priority' => TaskPriority::High->value,
            'status' => TaskStatus::ToDo->value,
            'due_date' => '2025-11-10',
            'created_by' => User::role('admin')->first()->id,
            'modified_by' => User::role('admin')->first()->id,
        ]);

        $organization->users()->sync(User::all()->pluck('id'));

        $project->users()->sync(
            [
                User::role('manager')->first()->id => [
                    'role' => ProjectUserRole::Manager->value
                ],
                User::role('member')->first()->id => [
                    'role' => ProjectUserRole::Member->value
                ]
            ]
        );
    }
}
