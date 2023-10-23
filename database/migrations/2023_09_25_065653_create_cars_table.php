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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('model');
            $table->unsignedBigInteger('year');
            $table->string('color');
            $table->enum('condition', ['bad', 'good', 'new']);
            $table->enum('status', ['waiting_validation', 'on_sale', 'not_sold', 'didnt_sell', 'sold_out'])->default('waiting_validation');
            $table->string('additional', 255)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('dealer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
