<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::all();

        foreach($cars as $car) {
            $images = [
                $car->image,
                'car_details1.png',
                'car_details2.png'
            ];

            foreach($images as $index => $image) {
                CarImage::create([
                    'image' => $image,
                    'car_id' => $car->id,
                ]);
            }
        }
    }
}
