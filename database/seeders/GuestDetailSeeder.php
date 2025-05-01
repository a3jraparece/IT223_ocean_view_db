<?php

namespace Database\Seeders;

use App\Models\GuestDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuestDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user['userRoles']['role_id'] == 4) {
                GuestDetail::create([
                    'user_id' => $user['id'],
                    'first_name' => null,
                    'middle_name' => null,
                    'sur_name' => null,
                    'suffix' => null,
                    'region' => null,
                    'province' => null,
                    'city' => null,
                    'phone_number' => null,
                ]);
            }
        }
    }
}
