<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'name'              => fake()->name(),
             'email'             => fake()->unique()->safeEmail(),
             'email_verified_at' => now(),
             'role'              => UserRole::CLIENT,
             'password'          => static::$password ??= Hash::make('password'),
             'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

     public function withRandomSkills(int $min = 2, int $max = 6) : Factory|UserFactory
     {

          return $this->state(new Sequence(function(Sequence $sequence) use ($min, $max) {
               $skills = [
                    'java', 'php', 'javascript', 'react', 'laravel', 'python', 'c++', 'c#',
                    'sql', 'mysql', 'postgresql', 'mongodb', 'oracle', 'firebase', 'html',
                    'css', 'tailwind', 'bootstrap', 'vue', 'angular', 'node.js', 'express.js',
                    'django', 'flask', 'spring boot', 'ruby', 'rails', 'go', 'rust', 'typescript'
               ];
               $shuffledSkills = Arr::shuffle($skills);
               $selectedSkills = array_slice($shuffledSkills, 0, rand($min, $max));
               return ['skills' => implode(',', $selectedSkills)];
          }));
     }
     public function freelancer(): static
     {
          return $this->state([
               'role'           => UserRole::FREELANCER,
               'experience'     => fake()->sentence(),
               'project_budget' => fake()->sentence(),
               'location'       => fake()->address()
          ]);
     }

     public function client(): static{
         return $this->state([
              'role'           => UserRole::CLIENT,
         ]);
     }
}
