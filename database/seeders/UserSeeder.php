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
            [
                "username" => "ResortAdmin1",
                "email" => "resortadmin1@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "BeachBoss",
                "email" => "beachboss@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "SandyManager",
                "email" => "sandymanager@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "TropicalTom",
                "email" => "tropical.tom@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "IslandIvy",
                "email" => "ivy.island@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "CoconutCarl",
                "email" => "carl.coconut@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "PalmPat",
                "email" => "pat.palm@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "LagoonLara",
                "email" => "lara.lagoon@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "WaveWalter",
                "email" => "walter.wave@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
            [
                "username" => "SeasideSue",
                "email" => "sue.seaside@example.com",
                "password" => bcrypt("superadmin"),
                "profile_photo" => null,
                "status" => "active",
            ],
        ];

        foreach ($initial_admins as $admin) {
            User::create($admin);
        }

        // User::factory(20)->create();
    }
}
