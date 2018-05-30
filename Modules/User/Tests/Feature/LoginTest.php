<?php

namespace Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client as OauthClient;
use Modules\User\Entities\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user login requires email and password.
     *
     * @return void
     */
    public function testLoginRequiresEmailAndPassword()
    {
        $this->json('POST', route('api.users.login'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'email'    => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    /**
     * Test user login unsuccessfully.
     *
     * @return void
     */
    public function testLoginsUnsuccessfully()
    {
        $client = OauthClient::create([
            'id' => config('auth.auth.api_client_id'),
            'name' => config('app.name').' Password Grant Client',
            'secret' => config('auth.auth.api_client_secret'),
            'redirect' => config('app.url'),
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0
        ]);

        $user = factory(User::class)->create([
            'email'    => 'test@login.com',
            'password' => Hash::make('secret'),
        ]);

        $payload = ['email' => $user->email, 'password' => 'badsecret'];

        $this->json('POST', route('api.users.login'), $payload)
            ->assertStatus(401)
            ->assertJson([
                'error'   => 'invalid_credentials',
                'message' => 'The user credentials were incorrect.',
            ]);
    }
}
