<?php

namespace Modules\Cryptocurrency\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

/**
 * @resource Cryptocurrencies
 */
class CryptocurrencyController extends Controller
{
    /**
     * Cryptocurrency repository
     *
     * @var Modules\Cryptocurrency\Repositories\CryptocurrencyRepository
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
     * Get cryptocurrencies paginated
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        if (!is_null($search)) {
            $this->cryptocurrencyRepository->where('name', 'like', '%'.$search.'%');
        }

        return $this->cryptocurrencyRepository->orderBy('rank', 'asc')->paginate(15);
    }

    /**
     * Get cryptocurrency information
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->cryptocurrencyRepository->findOrFail($id);
    }

    /**
     * Get cryptocurrency historical
     *
     * @param type $coinId
     * @return type
     */
    public function historical($coinId)
    {
        $coin = $this->cryptocurrencyRepository->with('historical')->findOrFail($coinId);
        
        return $coin->historical;
    }
}
