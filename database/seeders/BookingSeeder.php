<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $rooms = Room::all();

        foreach ($rooms as $room) {
            $existingRanges = [];

            for ($i = 0; $i < 5; $i++) { // Up to 5 bookings per room
                $attempts = 0;
                do {
                    $checkIn = Carbon::today()->addDays(rand(0, 100));
                    $length = rand(2, 5);
                    $checkOut = (clone $checkIn)->addDays($length);

                    // Check for date collisions
                    $collision = false;
                    foreach ($existingRanges as $range) {
                        if (
                            $checkIn < $range['check_out'] &&
                            $checkOut > $range['check_in']
                        ) {
                            $collision = true;
                            break;
                        }
                    }

                    $attempts++;
                } while ($collision && $attempts < 10);

                if ($collision) {
                    continue; // Give up if we can't find a slot
                }

                // Save the booking
                $existingRanges[] = [
                    'check_in' => $checkIn,
                    'check_out' => $checkOut
                ];

                Booking::create([
                    'user_id' => $users->random()->id,
                    'room_id' => $room->id,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'sub-total' => rand(1000, 3000),
                    'total_amount' => rand(1000, 3000),
                    'status' => 'Confirmed'
                ]);
            }
        }
    }
}
