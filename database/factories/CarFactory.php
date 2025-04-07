<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'image' => 'temp.jpg',
            'type_id' => \App\Models\Type::inRandomOrder()->first()->id,
            'capacity' => $this->faker->randomElement(['2', '4', '6', '8']),
            'steering' => $this->faker->randomElement(['manual', 'automatic', 'electric']),
            'gasoline' => $this->faker->numberBetween(1, 150),
            'price' => $this->faker->randomFloat(2, 70, 500),
            'sale_price' => $this->faker->optional(0.1, null)->randomFloat(2, 20, 60),
        ];
    }

    // public function withImage()
    // {
    //     return $this->afterCreating(function (\App\Models\Car $car) {
    //         // Generate a fake image and store it
    //         $imageUrl = "https://picsum.photos/800/600?random=" . $car->id;
    //         $imageContents = file_get_contents($imageUrl);

    //         $imagePath = 'cars/' . $car->id . '.jpg';
    //         Storage::put('public/' . $imagePath, $imageContents);

    //         $car->update(['image' => $imagePath]);
    //     });
    // }
}
