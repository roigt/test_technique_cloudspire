<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HotelFactory extends Factory
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
            'address1' => $this->faker->address(),
            'address2' => $this->faker->address(),
            'zipcode' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'lng' => $this->faker->longitude(),
            'lat' => $this->faker->latitude(),
            'description' => $this->faker->text(),
            'max_capacity' => $this->faker->numberBetween(1,100),
            'price_per_night' => $this->faker->numberBetween(1,100),
        ];
    }
}
