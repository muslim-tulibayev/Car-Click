<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropForeign(['highest_price_owner_id']);
            $table->dropColumn('highest_price_owner_id');
            $table->dropColumn('highest_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->unsignedBigInteger('highest_price')->default(0);
            $table->foreignId('highest_price_owner_id')
                ->nullable()
                ->references('id')
                ->on('dealers')
                ->cascadeOnDelete();
        });
    }
};
