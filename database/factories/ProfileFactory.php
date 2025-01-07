<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'profile_img' => null,
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'email' => fake()->unique()->email(),
            'last_name' => fake()->lastName(),
            'rfid' => fake()->unique()->numberBetween(000001, 99999),
        ];
    }
}
