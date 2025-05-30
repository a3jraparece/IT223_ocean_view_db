<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Resort;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $initial_buildings = [
        //     [
        //         'resort_id' => '1',
        //         'name' => 'Punta Verde Building 1',
        //         'image' => 'default.jpg',
        //         'floor_count' => '2',
        //         'room_per_floor' => '5',
        //     ],
        //     [
        //         'resort_id' => '2',
        //         'name' => 'Bruzy Building 1',
        //         'image' => 'default.jpg',
        //         'floor_count' => '1',
        //         'room_per_floor' => '10',
        //     ],
        // ];

        $resorts = Resort::all();

        foreach ($resorts as $resort) {
            $building_count = random_int(2, 4);
            Building::factory($building_count)->create(
                ['resort_id' => $resort['id']]
            );
        }
    }
}
