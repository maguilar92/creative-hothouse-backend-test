<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptocurrenciesHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptocurrencies_historical', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('cryptocurrency_id');
            $table->decimal('price_usd', 16, 8);
            $table->dateTime('snapshot_at');
            $table->foreign('cryptocurrency_id')->references('id')->on('cryptocurrencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cryptocurrencies_historical');
    }
}
