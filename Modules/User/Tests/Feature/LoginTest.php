<?php

namespace Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

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
                'errors' => [
                    'email' => ['The email field is required.'],
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
        $user = factory(User::class)->create([
            'email' => 'test@login.com',
            'password' => Hash::make('secret'),
        ]);

        $payload = ['email' => 'test@login.com', 'password' => 'badsecret'];

        $this->json('POST', route('api.users.login'), $payload)
            ->assertStatus(401)
            ->assertJson([
                'error' => 'invalid_credentials',
                'message' => 'The user credentials were incorrect.',
            ]);
        ;
    }
}
