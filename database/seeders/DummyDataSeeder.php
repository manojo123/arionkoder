<?php

namespace Database\Seeders;

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
            'status' => 'Planning',
        ]);

        $project->tasks()->create([
            'title' => 'AK-0001 - Finish Script',
            'user_id' => User::role('member')->first()->id,
            'description' => 'We need to finish the script for the project',
            'priority' => 'High',
            'status' => 'To Do',
            'due_date' => '2025-11-10',
            'created_by' => User::role('admin')->first()->id,
            'modified_by' => User::role('admin')->first()->id,
        ]);

        $organization->users()->sync(User::all()->pluck('id'));

        $project->users()->attach(
            User::role('manager')->first()->id,
            ['role' => 'manager']
        );
    }
}
