<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $initial_roles = [
            [
                'role' => 'super_admin',
                'description' => '',
            ],
            [
                'role' => 'resort_super_admin',
                'description' => '',
            ],
            [
                'role' => 'resort_admin',
                'description' => '',
            ],
            [
                'role' => 'guest',
                'description' => '',
            ],
        ];

        foreach ($initial_roles as $role) {
            Role::create($role);
        };
    }
}
