<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create([
            'name' => 'admin',
        ]);

        $mentorRole = Role::create([
            'name' => 'mentor',
        ]);

        $studentRole = Role::create([
            'name' => 'student',
        ]);

        $user = User::create([
            'name' => 'Team Obito',
            'email' => 'team@obito.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole($adminRole);
    }
}
