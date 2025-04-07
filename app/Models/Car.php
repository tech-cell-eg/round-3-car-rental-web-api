<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $withCount = ['reviews'];

    // Relations
    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class,'car_client','client_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }
}
