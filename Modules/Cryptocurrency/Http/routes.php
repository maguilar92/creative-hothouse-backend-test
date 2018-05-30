<?php

Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'Modules\Cryptocurrency\Http\Controllers\Api', 'as' => 'api.'], function()
{
    Route::apiResource('coins', 'CryptocurrencyController')->only(['index', 'show']);

    Route::get('coins/{coin}/historical', [
    	'as' => 'coin.historical',
        'uses' => 'CryptocurrencyController@historical',
    ]);
});

Route::group(['middleware' => ['api','auth:api'], 'prefix' => 'api', 'namespace' => 'Modules\Cryptocurrency\Http\Controllers\Api', 'as' => 'api.'], function()
{
	Route::apiResource('portfolio', 'PortfolioController')->only(['index', 'store']);
});
