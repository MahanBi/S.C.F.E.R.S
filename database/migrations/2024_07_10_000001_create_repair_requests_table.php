<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')
                ->constrained()
                ->onDelete('cascade');
                
            $table->foreignId('reporter_id')
                ->constrained('users')
                ->onDelete('cascade');
                
            $table->text('issue_description');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            
            $table->enum('status', [
                'reported',
                'assigned',
                'in_progress',
                'waiting_for_parts',
                'completed',
                'canceled'
            ])->default('reported');
            
            $table->foreignId('assigned_technician_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
                
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_requests');
    }
};