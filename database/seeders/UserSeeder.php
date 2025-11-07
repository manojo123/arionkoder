<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Organization Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $manager = User::create([
            'name' => 'Project Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
        ]);

        $member = User::create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');
        $manager->assignRole('manager');
        $member->assignRole('member');

    }
}
