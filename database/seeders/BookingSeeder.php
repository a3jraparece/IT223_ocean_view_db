<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Carbon\Carbon;

// use App\Models\Booking;
// use App\Models\Room;
// use App\Models\User;

// class BookingSeeder extends Seeder
// {
//     public function run()
//     {
//         $users = User::all();
//         $rooms = Room::all();

//         foreach ($rooms as $room) {
//             $existingRanges = [];

//             for ($i = 0; $i < 5; $i++) { // Up to 5 bookings per room
//                 $attempts = 0;
//                 do {
//                     $checkIn = Carbon::today()->addDays(rand(0, 100));
//                     $length = rand(2, 5);
//                     $checkOut = (clone $checkIn)->addDays($length);

//                     $collision = false;
//                     foreach ($existingRanges as $range) {
//                         if (
//                             $checkIn < $range['check_out'] &&
//                             $checkOut > $range['check_in']
//                         ) {
//                             $collision = true;
//                             break;
//                         }
//                     }

//                     $attempts++;
//                 } while ($collision && $attempts < 10);

//                 if ($collision) {
//                     continue; // Give up if we can't find a slot
//                 }

//                 // Save the booking
//                 $existingRanges[] = [
//                     'check_in' => $checkIn,
//                     'check_out' => $checkOut
//                 ];

//                 Booking::create([
//                     'user_id' => $users->random()->id,
//                     'room_id' => $room->id,
//                     'check_in' => $checkIn,
//                     'check_out' => $checkOut,
//                     'sub-total' => rand(1000, 3000),
//                     'total_amount' => rand(1000, 3000),
//                     'status' => 'Confirmed'
//                 ]);
//             }
//         }
//     }
// }


// namespace Database\Seeders;

// use App\Models\Resort;
// use App\Models\Booking;
// use App\Models\BookingDetail;
// use App\Models\User;
// use Carbon\Carbon;
// use Illuminate\Database\Seeder;

// class BookingSeeder extends Seeder
// {
//     public function run(): void
//     {
//         $users = User::all();

//         $pricePerNight = 7000;
//         $startRange = Carbon::now()->subMonth();
//         $endRange = Carbon::now()->addMonth();

//         foreach (Resort::with('buildings.rooms')->get() as $resort) {
//             foreach ($resort->buildings as $building) {
//                 foreach ($building->rooms as $room) {
//                     $bookings = [];

//                     foreach ($users as $user) {
//                         if (rand(1, 100) > 70) continue;

//                         $nights = rand(1, 5);
//                         $attempts = 0;

//                         while ($attempts < 10) {
//                             $checkIn = Carbon::createFromTimestamp(rand($startRange->timestamp, $endRange->subDays($nights)->timestamp))->startOfDay();
//                             $checkOut = (clone $checkIn)->addDays($nights);

//                             // Check for overlaps
//                             $overlap = Booking::where('room_id', $room->id)
//                                 ->where(function ($query) use ($checkIn, $checkOut) {
//                                     $query->whereBetween('check_in', [$checkIn, $checkOut->subDay()])
//                                           ->orWhereBetween('check_out', [$checkIn->addDay(), $checkOut]);
//                                 })
//                                 ->exists();

//                             if (!$overlap) {
//                                 $totalAmount = $nights * $pricePerNight;

//                                 $booking = Booking::create([
//                                     'user_id' => $user->id,
//                                     'room_id' => $room->id,
//                                     'check_in' => $checkIn,
//                                     'check_out' => $checkOut,
//                                     'sub-total' => null,
//                                     'total_amount' => $totalAmount,
//                                     'status' => 'Pending',
//                                 ]);

//                                 BookingDetail::create([
//                                     'booking_id' => $booking->id,
//                                     'price_per_night' => $pricePerNight,
//                                     'nights' => $nights,
//                                     'room_subtotal' => $totalAmount,
//                                     'discount' => 0.00,
//                                     'tax' => 0.00,
//                                     'final_price' => $totalAmount,
//                                 ]);

//                                 break;
//                             }

//                             $attempts++;
//                         }
//                     }
//                 }
//             }
//         }
//     }
// }

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\User;
// use App\Models\Resort;
// use App\Models\Booking;
// use App\Models\BookingDetail;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;

// class BookingSeeder extends Seeder
// {
//     public function run()
//     {
//         $pricePerNight = 7000;
//         $startRange = Carbon::now()->subMonth();
//         $endRange = Carbon::now()->addMonth();

//         // Only get users with role_id = 4
//         $users = User::whereHas('userRoles', function ($query) {
//             $query->where('role_id', 4);
//         })->get();

//         foreach (Resort::with('buildings.rooms')->get() as $resort) {
//             foreach ($resort->buildings as $building) {
//                 foreach ($building->rooms as $room) {
//                     foreach ($users as $user) {
//                         // Each user will have between 5 to 10 bookings
//                         $numberOfBookings = rand(5, 10);
//                         $userBookings = 0;
//                         $tries = 0;

//                         while ($userBookings < $numberOfBookings && $tries < $numberOfBookings * 5) {
//                             $nights = rand(1, 10);
//                             $checkIn = Carbon::createFromTimestamp(
//                                 rand($startRange->timestamp, $endRange->copy()->subDays($nights)->timestamp)
//                             )->startOfDay();
//                             $checkOut = (clone $checkIn)->addDays($nights);

//                             // Check for overlapping bookings in this room
//                             $overlap = Booking::where('room_id', $room->id)
//                                 ->where(function ($query) use ($checkIn, $checkOut) {
//                                     $query->whereBetween('check_in', [$checkIn, $checkOut->subDay()])
//                                         ->orWhereBetween('check_out', [$checkIn->addDay(), $checkOut]);
//                                 })
//                                 ->exists();

//                             if (!$overlap) {
//                                 $totalAmount = $nights * $pricePerNight;

//                                 $booking = Booking::create([
//                                     'user_id' => $user->id,
//                                     'room_id' => $room->id,
//                                     'check_in' => $checkIn,
//                                     'check_out' => $checkOut,
//                                     'sub-total' => null,
//                                     'total_amount' => $totalAmount,
//                                     'status' => 'Pending',
//                                 ]);

//                                 BookingDetail::create([
//                                     'booking_id' => $booking->id,
//                                     'price_per_night' => $pricePerNight,
//                                     'nights' => $nights,
//                                     'room_subtotal' => $totalAmount,
//                                     'discount' => 0.00,
//                                     'tax' => 0.00,
//                                     'final_price' => $totalAmount,
//                                 ]);

//                                 $userBookings++;
//                             }

//                             $tries++;
//                         }
//                     }
//                 }
//             }
//         }
//     }
// }


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Resort;
use App\Models\Booking;
use App\Models\BookingDetail;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $pricePerNight = 7000;
        $startRange = Carbon::now();//->subMonth()
        $endRange = Carbon::now()->addMonth();

        // Users with role_id = 4
        $users = User::whereHas('userRoles', function ($q) {
            $q->where('role_id', 4);
        })->get();


        foreach (Resort::with('buildings.rooms')->get() as $resort) {
            // Track user booking counts
            $userBookingCounts = [];

            foreach ($users as $user) {
                $userBookingCounts[$user->id] = rand(5, 10); // total bookings they are allowed
            }

            foreach ($resort->buildings as $building) {
                foreach ($building->rooms as $room) {
                    foreach ($users as $user) {

                        // Skip if user reached max bookings
                        if ($userBookingCounts[$user->id] <= 0) continue;

                        // 40% chance to try booking this room
                        if (rand(1, 100) > 40) continue;

                        $nights = rand(1, 10);
                        $attempts = 0;

                        while ($attempts < 10) {
                            $checkIn = Carbon::createFromTimestamp(rand(
                                $startRange->timestamp,
                                $endRange->copy()->subDays($nights)->timestamp
                            ))->startOfDay();

                            $checkOut = (clone $checkIn)->addDays($nights);

                            $overlap = Booking::where('room_id', $room->id)
                                ->where(function ($query) use ($checkIn, $checkOut) {
                                    $query->whereBetween('check_in', [$checkIn, $checkOut->copy()->subDay()])
                                        ->orWhereBetween('check_out', [$checkIn->copy()->addDay(), $checkOut]);
                                })
                                ->exists();

                            if (!$overlap) {
                                $totalAmount = $nights * $pricePerNight;

                                $booking = Booking::create([
                                    'user_id' => $user->id,
                                    'room_id' => $room->id,
                                    'check_in' => $checkIn,
                                    'check_out' => $checkOut,
                                    'sub-total' => null,
                                    'total_amount' => $totalAmount,
                                    'status' => 'Pending',
                                ]);

                                BookingDetail::create([
                                    'booking_id' => $booking->id,
                                    'price_per_night' => $pricePerNight,
                                    'nights' => $nights,
                                    'room_subtotal' => $totalAmount,
                                    'discount' => 0.00,
                                    'tax' => 0.00,
                                    'final_price' => $totalAmount,
                                ]);

                                $userBookingCounts[$user->id]--;
                                break; // only one booking per room attempt
                            }

                            $attempts++;
                        }
                    }
                }
            }
        }
    }
}
