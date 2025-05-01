<?php

namespace Database\Seeders;

use App\Models\Resort;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            [
                'user_id' => 5,
                'role_id' => 2,
                'resort_id' => 3,
            ],
            [
                'user_id' => 6,
                'role_id' => 2,
                'resort_id' => 4,
            ],
            [
                'user_id' => 7,
                'role_id' => 2,
                'resort_id' => 5,
            ],
            [
                'user_id' => 8,
                'role_id' => 2,
                'resort_id' => 6,
            ],
            [
                'user_id' => 9,
                'role_id' => 2,
                'resort_id' => 7,
            ],
            [
                'user_id' => 10,
                'role_id' => 2,
                'resort_id' => 8,
            ],
            [
                'user_id' => 11,
                'role_id' => 2,
                'resort_id' => 9,
            ],
            [
                'user_id' => 12,
                'role_id' => 2,
                'resort_id' => 10,
            ],
            [
                'user_id' => 13,
                'role_id' => 2,
                'resort_id' => 11,
            ],
            [
                'user_id' => 14,
                'role_id' => 2,
                'resort_id' => 12,
            ],
        ];

        foreach ($initial_user_roles as $role) {
            UserRole::create($role);
        }

        $resort_admins = User::factory(10)->create();

        $resorts = Resort::all();

        foreach ($resort_admins as $resort_admin) {
            UserRole::create(
                [
                    'user_id' => $resort_admin['id'],
                    'role_id' => 3,
                    'resort_id' => $resorts->random()->id,
                ]
            );
        }

        $initial_users = User::factory(10)->create();

        foreach ($initial_users as $initial_user) {
            UserRole::create(
                [
                    'user_id' => $initial_user['id'],
                    'role_id' => 4,
                    'resort_id' => null,
                ]
            );
        }
    }
}
