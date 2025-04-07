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
        foreach($cars as $car){
            for($i =1; $i <=3; $i++){
                CarImage::create([
                    'image' => 'temp' . $i . '.png',
                    'car_id' =>$car->id,
                ]);
            }
        }
    }
}
