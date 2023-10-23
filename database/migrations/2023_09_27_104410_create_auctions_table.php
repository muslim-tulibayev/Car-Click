<?php

use App\Models\Setting;
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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('starting_price');
            $table->unsignedBigInteger('highest_price')->default(0);
            $table->foreignId('highest_price_owner_id')
                ->nullable()
                ->references('id')
                ->on('dealers')
                ->cascadeOnDelete();
            $table->enum('life_cycle', ['waiting_start', 'playing', 'waiting_confirmation', 'finished'])->default('waiting_start');
            $table->dateTime('start');
            $table->dateTime('finish');
            $table->string('join_btn_message_id')->nullable();
            // $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
