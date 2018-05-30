<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptocurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptocurrencies', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 255);
            $table->string('symbol', 10);
            $table->string('logo', 255)->nullable();
            $table->unsignedMediumInteger('rank');
            $table->decimal('price_usd', 16, 8)->nullable();
            $table->decimal('price_btc', 16, 8)->nullable();
            $table->unsignedBigInteger('24h_volume_usd')->nullable();
            $table->unsignedBigInteger('market_cap_usd')->nullable();
            $table->unsignedBigInteger('available_supply')->nullable();
            $table->unsignedBigInteger('total_supply')->nullable();
            $table->decimal('percent_change_1h', 12, 8)->nullable();
            $table->decimal('percent_change_24h', 12, 8)->nullable();
            $table->decimal('percent_change_7d', 12, 8)->nullable();
            $table->timestamps();
            $table->index('rank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cryptocurrencies');
    }
}
