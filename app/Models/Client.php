<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Client extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // Relations
    public function cars()
    {
        return $this->belongsToMany(Car::class,'car_client','car_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
