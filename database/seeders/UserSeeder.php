<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initial_admins = [
            [
                "username" => "Ocean View ",
                "email" => "oceanview.superadmin@gmail.com",
                "password" => bcrypt(
                    "superadmin"
                ),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "Punta Verde ",
                "email" => "puntaverde.superadmin@gmail.com",
                "password" => bcrypt(
                    "superadmin"
                ),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "Bruzy Resort",
                "email" => "bruzyresort.superadmin@gmail.com",
                "password" => bcrypt(
                    "superadmin"
                ),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "Etriii",
                "email" => "alexarnaizaparece@gmail.com",
                "password" => bcrypt(
                    "superadmin"
                ),
                "profile_photo" => null,
                "status" => "active",
            ],
        ];

        foreach ($initial_admins as $admin) {
            User::create($admin);
        }
    }
}
