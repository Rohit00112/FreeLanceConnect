<?php

namespace Database\Factories;

use App\Enums\PostProjectStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostProject>
 */
class PostProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'project_name'        => $this->faker->word(),
             'project_description' => $this->faker->paragraph(),
             'budget'              => $this->faker->randomNumber(3),
             'deadline'            => $this->faker->dateTimeBetween('now', '+30 days'),
             'status'              => $this->faker->randomElement(PostProjectStatus::cases()),
             'client_id'           => User::factory()->client(),
             'freelancer_id'       => User::factory()->freelancer(),
        ];
    }
}
