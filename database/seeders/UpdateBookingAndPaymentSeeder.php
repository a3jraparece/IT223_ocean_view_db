<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateBookingAndPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            $random = rand(1, 100);

            if ($random <= 40) {
                // 40% chance: Confirmed
                $booking->status = 'Confirmed';
                $booking->save();

                Payment::create([
                    'booking_id' => $booking->id,
                    'payment_method' => 'Cash',
                    'amount_paid' => $booking->total_amount,
                    'received_by' => 1,
                    'payment_submission_id' => null,
                ]);
            } elseif ($random <= 50) {
                // Next 10%: Cancelled
                $booking->status = 'Cancelled';
                $booking->save();
            }
        }

        $date = Carbon::today()->format('Y-m-d');

        Booking::where('check_out', '<=', $date)
            ->where('status', '!=', 'Completed')
            ->update(['status' => 'Completed']);
    }
}
