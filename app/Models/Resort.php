<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'location',
        'location_coordinates',
        'tax_rate',
        'status',
        'status',
        'contact_details',
        'main_image',
        'image1',
        'image1_2',
        'image1_3',
        'image2',
        'image3',
        'resort_description',
        'amenities',
        'room_image_1',
        'room_image_2',
        'room_image_3',
        'room_description',
    ];
}
