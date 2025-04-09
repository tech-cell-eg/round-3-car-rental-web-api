<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    // Relations

    public function car()
    {
        return $this->belongsTo(Car::class,'car_id');
    }

    public function pickupCity()
    {
        return $this->belongsTo(City::class, 'pick_up_city_id');
    }

    public function dropoffCity()
    {
        return $this->belongsTo(City::class, 'drop_off_city_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
}
