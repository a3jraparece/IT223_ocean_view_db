<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'resort_id',
        'room_id',
        'check_in',
        'check_out',
        'sub-total',
        'total_amount',
        'status',
    ];

    public function bookingDetail()
    {
        return $this->hasOne(BookingDetail::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
