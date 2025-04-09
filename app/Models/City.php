<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // Relations
    public function pickupRentals()
    {
        return $this->hasMany(Rental::class, 'pickup_city_id');
    }

    public function dropoffRentals()
    {
        return $this->hasMany(Rental::class, 'drop_off_city_id');
    }
}
