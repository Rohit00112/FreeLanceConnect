<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'rating'        => $this->faker->numberBetween(3, 5),
             'review'        => $this->faker->realText(),
             'user_id'       => User::factory(),
             'freelancer_id' => User::factory()->client(),
        ];
    }
}
