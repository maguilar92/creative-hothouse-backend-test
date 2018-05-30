<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_trades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('cryptocurrency_id');
            $table->unsignedMediumInteger('user_id');
            $table->decimal('amount', 16, 8);
            $table->decimal('price_usd', 16, 8);
            $table->string('notes', 255);
            $table->datetime('traded_at');
            $table->timestamps();
            $table->foreign('cryptocurrency_id')->references('id')->on('cryptocurrencies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_trades');
    }
}
