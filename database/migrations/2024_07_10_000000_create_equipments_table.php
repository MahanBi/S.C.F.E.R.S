<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->enum('status', [
                'active', 
                'under_maintenance', 
                'out_of_service'
            ])->default('active');
            
            $table->foreignId('responsible_officer_id')
                ->constrained('users')
                ->onDelete('cascade');
                
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};