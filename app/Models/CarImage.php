<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    // Relations

    public function car()
    {
        $this->belongsTo(Car::class,'car_id');
    }
}
