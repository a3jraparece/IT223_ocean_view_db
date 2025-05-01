<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestDetail extends Model
{
    use HasFactory;

    protected $table = 'guest_details';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'sur_name',
        'suffix',
        'region',
        'province',
        'city',
        'phone_number',
        'status',
    ];
}
