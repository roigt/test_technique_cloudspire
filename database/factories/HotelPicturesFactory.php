<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelPictures>
 */
class HotelPicturesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' =>Hotel::factory(),
            'filepath' => $this->faker->imageUrl(),
            'filesize' => $this->faker->numberBetween(1,100),
            'position' => $this->faker->numberBetween(1,100),
        ];
    }
}
