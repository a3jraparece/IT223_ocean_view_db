<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use App\Models\Resort;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $resorts = Resort::all();

        foreach ($users as $user) {
            foreach ($resorts as $resort) {
                if (rand(1, 100) <= 40) {
                    Bookmark::create([
                        'user_id' => $user->id,
                        'resort_id' => $resort->id,
                    ]);
                }
            }
        }
    }
}
