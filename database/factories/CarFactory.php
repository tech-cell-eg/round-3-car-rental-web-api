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
            'image' => $this->faker->randomElement(['car1.jpg', 'car2.jpg', 'car3.jpg']),
            'type_id' => \App\Models\Type::inRandomOrder()->first()->id,
            'capacity' => $this->faker->randomElement(['2', '4', '6', '8']),
            'steering' => $this->faker->randomElement(['manual', 'automatic', 'electric']),
            'gasoline' => $this->faker->numberBetween(1, 150),
            'price' => $this->faker->randomFloat(2, 70, 500),
            'sale_price' => $this->faker->optional(0.1, null)->randomFloat(2, 20, 60),
        ];
    }

}
