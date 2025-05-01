<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmenityCategory extends Model
{
    use HasFactory;
    protected $table = 'amenities_category';

    protected $fillable = [
        'name',
        'description',
    ];
}
