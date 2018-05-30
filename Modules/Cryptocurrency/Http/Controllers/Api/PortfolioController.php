<?php

namespace Modules\Cryptocurrency\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Modules\Cryptocurrency\Http\Requests\PortfolioStoreRequest;

/**
 * @resource Portfolio
 */
class PortfolioController extends Controller
{
    /**
     * Portfolio repository.
     *
     * @var Modules\Cryptocurrency\Repositories\PortfolioRepository
     */
    protected $cryptocurrencyRepository;

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userTradeRepository = App::make('Modules\Cryptocurrency\Repositories\UserTradeRepository');
    }

    /**
     * Get cryptocurrencies paginated.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->userTradeRepository->orderBy('id', 'desc')->get();
    }

    /**
     * Store new user trade.
     *
     * @param PortfolioStoreRequest $request
     *
     * @return string JSON
     */
    public function store(PortfolioStoreRequest $request)
    {
        return auth()->guard('api')->user()->trades()->create([
            'cryptocurrency_id' => $request->get('cryptocurrency_id'),
            'amount'            => $request->get('amount'),
            'price_usd'         => $request->get('price_usd'),
            'notes'             => $request->get('notes') ?? '',
            'traded_at'         => $request->get('traded_at'),
        ]);
    }
}
