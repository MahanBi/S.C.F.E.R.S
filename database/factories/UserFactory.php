<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $roles = ['admin', 'equipment_manager', 'technician', 'equipment_officer'];
        
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'role_key' => $this->faker->randomElement($roles),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'role_key' => 'admin',
            'email' => 'admin_' . Str::random(8) . '@scfers.local',
        ]);
    }

    public function equipmentManager(): static
    {
        return $this->state([
            'role_key' => 'equipment_manager',
            'email' => 'manager_' . Str::random(8) . '@scfers.local',
        ]);
    }

    public function technician(): static
    {
        return $this->state([
            'role_key' => 'technician',
            'email' => 'tech_' . Str::random(8) . '@scfers.local',
        ]);
    }

    public function equipmentOfficer(): static
    {
        return $this->state([
            'role_key' => 'equipment_officer',
            'email' => 'officer_' . Str::random(8) . '@scfers.local',
        ]);
    }
}