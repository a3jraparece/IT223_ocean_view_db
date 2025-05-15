<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AmenityCategory;
use App\Models\GuestDetail;
use App\Models\RoomType;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ResortSeeder::class,
            BuildingSeeder::class,
            RoleSeeder::class,
            UserRoleSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            EventSeeder::class,
            AmenityCategorySeeder::class,
            ResortAmenitySeeder::class,
            BookmarkSeeder::class,
            ReviewSeeder::class,
            GuestDetailSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
