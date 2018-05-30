<?php

namespace Modules\Cryptocurrency\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

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
