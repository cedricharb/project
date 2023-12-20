<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Acount>
 */
class AcountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomDigit(),
            'number' => $this->faker->randomDigit(),
            'currency' => $this->faker->randomDigit(),
            'status' => $this->faker->randomDigit(),
        ];
    }
}
