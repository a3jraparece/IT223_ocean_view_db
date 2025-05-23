<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'resort_id',
        'name',
        'image',
        'floor_count',
        'room_per_floor',
    ];

    // protected $with = [
    //     'resort'
    // ];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
