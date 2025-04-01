<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $initial_user_roles = [
            [
                'user_id' => '1',
                'role_id' => '1',
                'resort_id' => null,
            ],
            [
                'user_id' => '2',
                'role_id' => '2',
                'resort_id' => '1',
            ],
            [
                'user_id' => '3',
                'role_id' => '2',
                'resort_id' => '2',
            ],
            [
                'user_id' => '4',
                'role_id' => '4',
                'resort_id' => null,
            ],
        ];

        foreach ($initial_user_roles as $role) {
            UserRole::create($role);
        }
    }
}
