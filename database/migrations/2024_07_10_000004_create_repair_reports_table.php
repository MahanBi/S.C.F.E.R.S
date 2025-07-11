<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_request_id')
                ->constrained()
                ->onDelete('cascade');
                
            $table->text('technician_summary')->nullable();
            $table->text('parts_used')->nullable();
            $table->integer('repair_duration_minutes')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            
            $table->enum('final_status', [
                'repaired',
                'replaced',
                'cannot_repair'
            ]);
            
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
                
            $table->timestamp('report_submitted_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_reports');
    }
};