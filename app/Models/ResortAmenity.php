<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortAmenity extends Model
{
    use HasFactory;

    protected $table = 'resort_amenities';

    protected $fillable = [
        'resort_id',
        'amenity_category_id',
        'amenity',
    ];
}
