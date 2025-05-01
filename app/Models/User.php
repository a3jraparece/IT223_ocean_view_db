<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $with = ['userRoles'];

    protected $fillable = [
        'username',
        'email',
        'email_verified_at',
        'profile_photo',
        'status',
        'remember_token',
        'password',
    ];

    public function userRoles()
    {
        return  $this->hasOne(UserRole::class, 'user_id');
    }
}
