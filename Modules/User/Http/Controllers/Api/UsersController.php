<?php

namespace Modules\User\Http\Controllers\Api;

use CreativeHotHouse\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserLoginRequest;

/**
 * @resource Users
 */
class UsersController extends Controller
{
    /**
     * User repository
     *
     * @var Modules\User\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepository = App::make('Modules\User\Repositories\UserRepository');
    }

    /**
     * Login user
     * 
     * @param UserLoginRequest $request 
     * @return string JSON
     */
    public function login(UserLoginRequest $request)
    {
        try {
            // Attempt to log the user admin in
            $http = new \GuzzleHttp\Client([
                    'verify' => !app()->isLocal()
                ]);
            $response = $http->post(url('oauth/token'), [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => config('auth.auth.api_client_id'),
                        'client_secret' => config('auth.auth.api_client_secret'),
                        'username' => $request->get('email'),
                        'password' => $request->get('password'),
                        'scope' => null,
                    ],
                ]);
            return response($response->getBody()->getContents(), $response->getStatusCode());
        } catch (RequestException $e) {
            return response($e->getResponse()->getBody()->getContents(), $e->getResponse()->getStatusCode());
        }
    }
}
