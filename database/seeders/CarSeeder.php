<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $cars = [
            'car1' => [
                'name' => 'Koenigsegg',
                'type_id' => 1,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car1.png',
                'capacity' => '2',
                'steering' => 'Manual',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car2' => [
                'name' => 'Nissan GT - R',
                'type_id' => 1,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car2.png',
                'capacity' => '2',
                'steering' => 'Manual',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car3' => [
                'name' => 'Rolls-Royce',
                'type_id' => 1,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car3.png',
                'capacity' => '4',
                'steering' => 'Manual',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car4' => [
                'name' => 'All New Rush',
                'type_id' => 2,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car4.png',
                'capacity' => '6',
                'steering' => 'Manual',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car5' => [
                'name' => 'CR  - V',
                'type_id' => 2,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car5.png',
                'capacity' => '6',
                'steering' => 'Manual',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car6' => [
                'name' => 'All New Terios',
                'type_id' => 2,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car6.png',
                'capacity' => '6',
                'steering' => 'Manual',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car7' => [
                'name' => 'MG ZX Exclusice',
                'type_id' => 6,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car7.png',
                'capacity' => '4',
                'steering' => 'Electric',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car8' => [
                'name' => 'New MG ZS',
                'type_id' => 2,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car8.png',
                'capacity' => '6',
                'steering' => 'Manual',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
            'car9' => [
                'name' => 'MG ZX Excite',
                'type_id' => 6,
                'description' => "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the 'race track'.",
                'image' => 'car9.png',
                'capacity' => '4',
                'steering' => 'Electric',
                'gasoline' => rand(50,150),
                'price' => number_format(rand(7000, 50000) / 100, 2, '.', ''),
                'sale_price' => $faker->optional(0.4, null)->randomFloat(2, 20, 60),
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
