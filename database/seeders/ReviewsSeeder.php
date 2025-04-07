<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Client;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $cars = Car::all();

        foreach($cars as $car) {
            // Get 2 unique random clients for this car
            $reviewers = $clients->random(2);

            foreach($reviewers as $client) {
                Review::create([
                    'car_id' => $car->id,
                    'client_id' => $client->id,
                    'rating' => rand(1, 5),
                    'description' => fake()->paragraph(),
                ]);
            }
        }
    }
}
