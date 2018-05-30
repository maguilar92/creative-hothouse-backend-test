<?php

Route::group(['middleware' => ['api', 'guest:api'], 'prefix' => 'api', 'namespace' => 'Modules\User\Http\Controllers\Api', 'as' => 'api.'], function () {
    Route::post('users/login', [
        'as'   => 'users.login',
        'uses' => 'UsersController@login',
    ]);
});

// Route::group(['middleware' => ['api','auth:admin-api'], 'namespace' => 'Modules\User\Http\Controllers\Api', 'prefix' => 'api', 'as' => 'api.'], function()
// {
// 	Route::resources([
// 		'users-admins' => 'UsersAdminsController',
// 		'users' => 'UsersController'
// 	]);
// });
