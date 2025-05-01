<?php

namespace Database\Seeders;

use App\Models\AmenityCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmenityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pool', 'description' => 'Swimming pool with a relaxing atmosphere.'],
            ['name' => 'Gym', 'description' => 'Fully equipped fitness center with modern machines.'],
            ['name' => 'Spa', 'description' => 'Relaxing spa services for body and mind rejuvenation.'],
            ['name' => 'Restaurant', 'description' => 'Fine dining experience offering local and international cuisines.'],
            ['name' => 'Bar', 'description' => 'Full-service bar with a variety of alcoholic and non-alcoholic beverages.'],
            ['name' => 'WiFi', 'description' => 'Free high-speed internet access throughout the property.'],
            ['name' => 'Parking', 'description' => 'Spacious parking area with secure access for guests.'],
            ['name' => 'Room Service', 'description' => '24/7 room service for food and other amenities.'],
            ['name' => 'Business Center', 'description' => 'Workstations with computers, fax, and copy services for business travelers.'],
            ['name' => 'Conference Rooms', 'description' => 'State-of-the-art meeting and event spaces available for booking.'],
        ];

        // Insert categories into the database
        foreach ($categories as $category) {
            AmenityCategory::create($category);
        }
    }
}
