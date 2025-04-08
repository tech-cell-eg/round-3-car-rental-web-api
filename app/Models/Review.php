<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Relations
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
    public function car()
    {
        return $this->belongsTo(Car::class,'car_id');
    }
}
