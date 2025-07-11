<?php

namespace Database\Factories;

use App\Models\RepairChat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatMessageFactory extends Factory
{
    public function definition(): array
    {
        $types = ['normal', 'technical_note', 'failure_report', 'completion_confirmation'];
        
        return [
            'chat_id' => RepairChat::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'message' => $this->faker->paragraph(rand(1, 3)),
            'type' => $this->faker->randomElement($types),
            'attachment_path' => $this->faker->optional(0.3)->filePath(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function technicalNote(): static
    {
        return $this->state([
            'type' => 'technical_note',
            'message' => 'یادداشت فنی: ' . $this->faker->sentence(),
        ]);
    }

    public function failureReport(): static
    {
        return $this->state([
            'type' => 'failure_report',
            'message' => 'گزارش خرابی: ' . $this->faker->sentence(),
        ]);
    }

    public function completionConfirmation(): static
    {
        return $this->state([
            'type' => 'completion_confirmation',
            'message' => 'تأیید تکمیل تعمیر: ' . $this->faker->sentence(),
        ]);
    }
}