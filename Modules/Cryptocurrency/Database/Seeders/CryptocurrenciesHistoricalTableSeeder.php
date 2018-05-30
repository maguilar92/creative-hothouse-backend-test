<?php

namespace Modules\Cryptocurrency\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Modules\Cryptocurrency\Entities\Cryptocurrency;

class CryptocurrenciesHistoricalTableSeeder extends Seeder
{
    /**
     * Worker role repository
     *
     * @var \Modules\Worker\Repositories\WorkerRoleRepository
     */
    protected $cryptocurrencyRepository;
    
    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->cryptocurrencyRepository = App::make('Modules\Cryptocurrency\Repositories\CryptocurrencyRepository');
    }

    /**
     * Generate decimal random
     *
     * @param float $min
     * @param float $max
     * @param int $decimals
     * @return type
     */
    protected function random(float $min, float $max, int $decimals = 8)
    {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }

    /**
     * Add new snapshop
     *
     * @param Cryptocurrency $cryptocurrency
     * @param float $lastSnapshotPriceUsd
     * @param type $dateFake
     * @return float
     */
    protected function addSnapshot(Cryptocurrency $cryptocurrency, float $lastSnapshotPriceUsd, Carbon $dateFake)
    {
        $snapshotPrice = $lastSnapshotPriceUsd == 0 ? 0.1 : $lastSnapshotPriceUsd;

        //Calculate snapshot pricr
        $minPrice = 95*($snapshotPrice/100);
        $maxPrice = 105*($snapshotPrice/100);
        $snapshotPrice = $this->random($minPrice, $maxPrice);

        //Create the snapshot
        $cryptocurrency->historical()->create([
            'price_usd' => $snapshotPrice,
            'snapshot_at' => $dateFake
        ]);

        return $snapshotPrice;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //For each cryptocurrency generate fake data
        $this->cryptocurrencyRepository->all()->each(function ($cryptocurrency) {
            $dateFake = $cryptocurrency->updated_at->subHour();
            $dateEndFake = $cryptocurrency->updated_at->subMonths(6);
            $lastSnapshotPriceUsd = $cryptocurrency->price_usd;

            while ($dateFake->gte($dateEndFake)) {
                $lastSnapshotPriceUsd = $this->addSnapshot($cryptocurrency, $lastSnapshotPriceUsd, $dateFake);
                $dateFake->subHour();
            }

            $dateFake = Carbon::now();
        });
    }
}
