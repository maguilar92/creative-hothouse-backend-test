<?php

namespace Modules\Cryptocurrency\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CryptocurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(CryptocurrenciesTableSeeder::class);
        $this->call(CryptocurrenciesHistoricalTableSeeder::class);
        Model::reguard();
    }
}
