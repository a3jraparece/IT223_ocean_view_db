<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Resort;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $buildings = Building::all();
        $buildings = Building::with('resort')->get();
        $room_types = RoomType::all();

        foreach ($buildings as $building) {
            $floor_count = $building['floor_count'];
            $room_per_floor = $building['room_per_floor'];

            for ($i = 1; $i <= $floor_count; $i++) {
                for ($j = 1; $j <= $room_per_floor; $j++) {
                    $random_room_type = $room_types->random();
                    Room::create(
                        [
                            'building_id' => $building['id'],
                            'resort_id' => $building['resort']['id'],
                            'room_type_id' => $random_room_type->id,
                            'room_name' =>  $this->getAcronym($building['name']) . ' ' . $i . '-' . $j,
                            'room_image' => null,
                            'description' => null,
                            'inclusions' => null,
                            'amenities' => null,
                            'price_per_night' => $random_room_type->base_price,
                            'is_available' => 0,
                        ]
                    );
                }
            }
        }
    }

    public function getAcronym($string)
    {
        $words = preg_split('/\s+/', trim($string));
        $acronym = "";

        foreach ($words as $word) {
            // if (ctype_alpha($word[0])) { // Ensure it's a letter
            $acronym .= strtoupper($word[0]);
            // }
        }

        return $acronym;
    }
}
