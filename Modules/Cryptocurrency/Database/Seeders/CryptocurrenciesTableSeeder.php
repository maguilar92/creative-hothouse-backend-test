<?php

namespace Modules\Cryptocurrency\Database\Seeders;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CryptocurrenciesTableSeeder extends Seeder
{
    /**
     * Worker role repository.
     *
     * @var \Modules\Worker\Repositories\WorkerRoleRepository
     */
    protected $cryptocurrencyRepository;

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cryptocurrencyRepository = App::make('Modules\Cryptocurrency\Repositories\CryptocurrencyRepository');
    }

    /**
     * Get CoinMarketCap tickets.
     *
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    protected function getCoinMarketCapTickers(int $start, int $limit): array
    {
        try {
            // Get coins from coin market cap api
            $http = new \GuzzleHttp\Client();
            $response = $http->get('https://api.coinmarketcap.com/v2/ticker/?convert=BTC&start='.$start.'&limit='.$limit);
            $body = $response->getBody();
            $body = json_decode($body, true);

            return [
                'content' => collect($body['data']),
                'code'    => $response->getStatusCode(),
            ];
        } catch (RequestException $e) {
            return [
                'content' => $e->getResponse()->getBody()->getContents(),
                'code'    => $e->getResponse()->getStatusCode(),
            ];
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = 1;
        $limit = 100;
        $cryptocurrencies = $this->getCoinMarketCapTickers($start, $limit);

        //While coin market cap api return coins insert coins in database
        while ($cryptocurrencies['code'] == 200) {
            $cryptocurrencies['content']->each(function ($cryptocurrency) {
                $this->cryptocurrencyRepository->create([
                    'name'               => $cryptocurrency['name'],
                    'symbol'             => $cryptocurrency['symbol'],
                    'rank'               => $cryptocurrency['rank'],
                    'price_usd'          => $cryptocurrency['quotes']['USD']['price'],
                    'price_btc'          => $cryptocurrency['quotes']['BTC']['price'],
                    '24h_volume_usd'     => $cryptocurrency['quotes']['USD']['volume_24h'],
                    'market_cap_usd'     => $cryptocurrency['quotes']['USD']['market_cap'],
                    'available_supply'   => $cryptocurrency['circulating_supply'],
                    'total_supply'       => $cryptocurrency['total_supply'],
                    'percent_change_1h'  => $cryptocurrency['quotes']['USD']['percent_change_1h'],
                    'percent_change_24h' => $cryptocurrency['quotes']['USD']['percent_change_24h'],
                    'percent_change_7d'  => $cryptocurrency['quotes']['USD']['percent_change_7d'],
                ]);
            });

            $start += $limit;
            $cryptocurrencies = $this->getCoinMarketCapTickers($start, $limit);
        }
    }
}
