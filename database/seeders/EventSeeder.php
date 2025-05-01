<?php

namespace Database\Seeders;

use App\Models\Resort;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resorts = Resort::all();

        foreach ($resorts as $resort) {
            Event::factory()->count(3)->create([
                'resort_id' => $resort->id
            ]);
        }
    }
}
