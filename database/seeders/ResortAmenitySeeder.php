<?php

namespace Database\Seeders;

use App\Models\AmenityCategory;
use App\Models\Resort;
use App\Models\ResortAmenity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResortAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryAmenities = [
            'Gym' => ['Treadmills', 'Weight Machines', 'Free Weights', 'Elliptical Machines'],
            'Pool' => ['Infinity Pool', 'Kids Pool', 'Jacuzzi'],
            'Spa' => ['Massage', 'Facial Treatments', 'Sauna', 'Aromatherapy'],
            'Restaurant' => ['Buffet', 'A La Carte', '24/7 Room Service'],
            'Bar' => ['Cocktail Bar', 'Wine Selection', 'Craft Beers'],
            'WiFi' => ['Free WiFi in rooms', 'Free WiFi in lobby', 'Free WiFi at poolside'],
            'Parking' => ['Covered Parking', 'Outdoor Parking', 'Valet Service'],
            'Room Service' => ['Breakfast in Room', 'Dinner in Room', 'Special Dietary Menu'],
            'Business Center' => ['Workstations', 'Fax', 'Copy Services'],
            'Conference Rooms' => ['Small Meeting Room', 'Large Conference Hall'],
        ];

        $resorts = Resort::all();

        foreach ($resorts as $resort) {
            foreach ($categoryAmenities as $categoryName => $amenities) {
                $category = AmenityCategory::where('name', $categoryName)->first();

                if ($category) {
                    foreach ($amenities as $amenity) {
                        ResortAmenity::create([
                            'resort_id' => $resort->id,
                            'amenity_category_id' => $category->id,
                            'amenity' => $amenity,
                        ]);
                    }
                }
            }
        }
    }
}
