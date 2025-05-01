<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillbale = [
        'resort_id',
        'name',
        'image',
        'floor_count',
        'room_per_floor',
    ];
}
