<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')
                ->constrained('repair_chats')
                ->onDelete('cascade');
                
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
                
            $table->text('message');
            
            $table->enum('type', [
                'normal',
                'technical_note',
                'failure_report',
                'completion_confirmation'
            ])->default('normal');
            
            $table->string('attachment_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};