<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\PostProject;
use App\Models\Project;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         User::factory()->create([
              'name'  => 'admin',
              'email' => 'admin@example.com',
              'role'  => UserRole::ADMIN,
         ]);

         $client = User::factory()->client()->create([
             'name'  => 'Client',
             'email' => 'client@example.com',
        ]);
         $freeLancer = User::factory()->freelancer()->has(Project::factory()->count(6))->withRandomSkills()->create([
              'name'  => 'freelancer',
              'email' => 'freelancer@example.com',
              'role'  => UserRole::FREELANCER,
         ]);

         PostProject::factory()->count(15)->create([
              'freelancer_id' => $freeLancer->id,
              'client_id'     => $client->id,
         ]);

         User::factory()->client()->count(10)->create()->each(function ($user) use ($freeLancer) {
              $user->givenReviews->add(Rating::factory()->create(['freelancer_id' => $freeLancer->id]));
         });

         User::factory()->freelancer()->withRandomSkills()
              ->has(Project::factory()->count(6))
              ->count(50)->create();

    }
}
