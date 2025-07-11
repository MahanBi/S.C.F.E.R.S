<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_request_id')
                ->constrained()
                ->onDelete('cascade');
                
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_chats');
    }
};