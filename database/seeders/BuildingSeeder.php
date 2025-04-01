<?php

namespace Database\Seeders;

use App\Models\Buildings;
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

        $initial_buildings = [
            [
                'resort_id' => '1',
                'name' => 'Punta Verde Building 1',
                'floor_count' => '2',
                'room_per_floor' => '5',
            ],
            [
                'resort_id' => '2',
                'name' => 'Bruzy Building 1',
                'floor_count' => '1',
                'room_per_floor' => '10',
            ],
        ];

        foreach ($initial_buildings as $buildings) {
            Buildings::create($buildings);
        }
    }
}
