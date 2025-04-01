<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
{
    use HasFactory;

    protected $fillbale = [
        'resort_id',
        'name',
        'floor_count',
        'room_per_floor',
    ];
}
