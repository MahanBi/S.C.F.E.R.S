<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    public function definition(): array
    {
        $events = [
            'created_equipment',
            'updated_equipment',
            'deleted_equipment',
            'created_repair_request',
            'assigned_technician',
            'completed_repair',
        ];
        
        return [
            'event' => $this->faker->randomElement($events),
            'description' => $this->faker->sentence,
            'user_id' => User::inRandomOrder()->first()->id,
            'loggable_id' => $this->faker->numberBetween(1, 100),
            'loggable_type' => $this->faker->randomElement([
                'App\Models\Equipment',
                'App\Models\RepairRequest',
                'App\Models\RepairReport'
            ]),
            'properties' => json_encode(['ip' => $this->faker->ipv4]),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}