<?php

namespace Database\Factories;

use App\Models\RepairRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairChatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'repair_request_id' => RepairRequest::inRandomOrder()->first()->id,
            'is_active' => $this->faker->boolean(90),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }
}