<?php

namespace Database\Seeders;

use Faker\Factory as Faker;

use App\Models\Resort;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $users = User::all();
        $resorts = Resort::all();

        foreach ($users as $user) {
            foreach ($resorts as $resort) {
                if (rand(1, 100) <= 30) {
                    Review::create([
                        'user_id' => $user->id,
                        'resort_id' => $resort->id,
                        'ratings' => rand(1, 5),
                        'comments' =>  $faker->sentence,
                    ]);
                }
            }
        }
    }
}
