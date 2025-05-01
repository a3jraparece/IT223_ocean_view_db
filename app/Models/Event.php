<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'resort_events';

    protected $fillable = [
        'resort_id',
        'name',
        'name',
        'discount_rate',
        'description',
        'start_date',
        'end_date',
    ];
}
