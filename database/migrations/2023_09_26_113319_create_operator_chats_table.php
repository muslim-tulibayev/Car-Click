<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operator_chats', function (Blueprint $table) {
            $table->id();
            $table->string('chat_id')->unique('idx_chat_id');
            $table->foreignId('operator_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('action')->nullable();
            $table->string('data')->nullable();
            $table->enum('lang', ['en', 'uz', 'ru'])->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_chats');
    }
};
