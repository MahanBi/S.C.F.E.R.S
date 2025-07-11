<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['active', 'under_maintenance', 'out_of_service'];
        
        return [
            'name' => $this->faker->randomElement([
                'کمباین نیشکر ' . $this->faker->bothify('???-##'),
                'تراکتور ترانسپورت ' . $this->faker->bothify('???-##'),
                'پمپ آبیاری ' . $this->faker->bothify('???-##'),
                'دستگاه بسته‌بندی ' . $this->faker->bothify('???-##'),
                'سیستم آبیاری قطره‌ای ' . $this->faker->bothify('???-##'),
            ]),
            'description' => $this->faker->paragraph(3),
            'serial_number' => 'EQ-' . strtoupper($this->faker->bothify('????-####')),
            'status' => $this->faker->randomElement($statuses),
            'responsible_officer_id' => User::where('role_key', 'equipment_officer')->inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function active(): static
    {
        return $this->state([
            'status' => 'active',
        ]);
    }

    public function underMaintenance(): static
    {
        return $this->state([
            'status' => 'under_maintenance',
        ]);
    }

    public function outOfService(): static
    {
        return $this->state([
            'status' => 'out_of_service',
        ]);
    }
}