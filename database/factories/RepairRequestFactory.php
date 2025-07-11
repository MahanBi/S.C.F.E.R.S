<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairRequestFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['reported', 'assigned', 'in_progress', 'waiting_for_parts', 'completed', 'canceled'];
        $priorities = ['low', 'medium', 'high', 'critical'];
        
        return [
            'equipment_id' => Equipment::inRandomOrder()->first()->id,
            'reporter_id' => User::where('role_key', 'equipment_officer')->inRandomOrder()->first()->id,
            'issue_description' => $this->faker->paragraph(3),
            'priority' => $this->faker->randomElement($priorities),
            'status' => $this->faker->randomElement($statuses),
            'assigned_technician_id' => $this->faker->randomElement([
                null,
                User::where('role_key', 'technician')->inRandomOrder()->first()->id
            ]),
            'assigned_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'completed_at' => $this->faker->optional(0.3)->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function reported(): static
    {
        return $this->state([
            'status' => 'reported',
            'assigned_technician_id' => null,
            'assigned_at' => null,
        ]);
    }

    public function assigned(): static
    {
        return $this->state([
            'status' => 'assigned',
            'assigned_technician_id' => User::where('role_key', 'technician')->inRandomOrder()->first()->id,
            'assigned_at' => now(),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state([
            'status' => 'in_progress',
            'assigned_technician_id' => User::where('role_key', 'technician')->inRandomOrder()->first()->id,
            'assigned_at' => now()->subDays(rand(1, 3)),
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
            'assigned_technician_id' => User::where('role_key', 'technician')->inRandomOrder()->first()->id,
            'assigned_at' => now()->subDays(rand(3, 7)),
            'completed_at' => now(),
        ]);
    }
}