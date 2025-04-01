<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initial_room_types = [
            [
                'name' => 'King Size',
                'description' => 'A spacious room with a king-sized bed, ideal for couples or solo travelers looking for extra comfort.',
                'capacity' => 5,
                'base_price' => 3500.00
            ],
            [
                'name' => 'Queen Size',
                'description' => 'A comfortable room with a queen-sized bed, perfect for two guests.',
                'capacity' => 4,
                'base_price' => 3000.00
            ],
            [
                'name' => 'Twin Bed',
                'description' => 'A room with two twin beds, suitable for friends or colleagues traveling together.',
                'capacity' => 2,
                'base_price' => 2800.00
            ],
            [
                'name' => 'Deluxe Suite',
                'description' => 'A luxurious suite with premium amenities, a spacious lounge area, and a king-sized bed.',
                'capacity' => 4,
                'base_price' => 5000.00
            ],
            [
                'name' => 'Family Room',
                'description' => 'A large room with multiple beds, ideal for families or small groups.',
                'capacity' => 7,
                'base_price' => 4000.00
            ],
            [
                'name' => 'Penthouse Suite',
                'description' => 'An exclusive penthouse with stunning views, a private lounge, and high-end furnishings.',
                'capacity' => 10,
                'base_price' => 8000.00
            ],
            [
                'name' => 'Bungalow Villa',
                'description' => 'A private bungalow-style villa with direct beach access and a cozy outdoor seating area.',
                'capacity' => 8,
                'base_price' => 6000.00
            ]
        ];

        foreach ($initial_room_types as $room_type) {
            RoomType::create($room_type);
        }

    }
}
