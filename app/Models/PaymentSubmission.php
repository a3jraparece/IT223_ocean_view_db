<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSubmission extends Model
{
    use HasFactory;

    protected $table = 'payment_submissions';

    protected $fillable = [
        'booking_id',
        'screenshot_path',
        'amount_paid',
        'reference_number',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];
}
