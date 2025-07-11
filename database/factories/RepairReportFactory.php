<?php

namespace Database\Factories;

use App\Models\RepairRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairReportFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['repaired', 'replaced', 'cannot_repair'];
        
        return [
            'repair_request_id' => RepairRequest::where('status', 'completed')->inRandomOrder()->first()->id,
            'technician_summary' => $this->faker->paragraph(3),
            'parts_used' => $this->faker->words(rand(1, 5), true),
            'repair_duration_minutes' => $this->faker->numberBetween(30, 480),
            'cost' => $this->faker->numberBetween(500000, 50000000),
            'final_status' => $this->faker->randomElement($statuses),
            'approved_by' => User::where('role_key', 'equipment_manager')->inRandomOrder()->first()->id,
            'report_submitted_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function repaired(): static
    {
        return $this->state([
            'final_status' => 'repaired',
            'technician_summary' => 'تعمیر با موفقیت انجام شد و تجهیز به حالت عملیاتی بازگشت',
        ]);
    }

    public function replaced(): static
    {
        return $this->state([
            'final_status' => 'replaced',
            'technician_summary' => 'قطعه معیوب تعویض شد و تجهیز به حالت عملیاتی بازگشت',
        ]);
    }

    public function cannotRepair(): static
    {
        return $this->state([
            'final_status' => 'cannot_repair',
            'technician_summary' => 'به دلیل شدت خرابی، تعمیر امکان‌پذیر نبود و نیاز به جایگزینی کامل دارد',
        ]);
    }
}