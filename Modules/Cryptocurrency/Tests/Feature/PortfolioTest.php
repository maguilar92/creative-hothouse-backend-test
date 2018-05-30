<?php

namespace Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Modules\Cryptocurrency\Entities\Cryptocurrency;
use Modules\Cryptocurrency\Entities\UserTrade;
use Modules\User\Entities\User;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test cryptocurrency index.
     *
     * @return void
     */
    public function testPortfolioIndex()
    {
        $user = factory(User::class)->create();
        $cryptocurrency = factory(Cryptocurrency::class)->create();
        factory(UserTrade::class, 25)->create([
            'user_id'           => $user->id,
            'cryptocurrency_id' => $cryptocurrency->id,
        ]);

        $response = $this->actingAs($user, 'api')->get(route('api.portfolio.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(25);
    }

    /**
     * Test valid portfolio store.
     *
     * @return void
     */
    public function testValidPortfolioStore()
    {
        $user = factory(User::class)->create();
        $cryptocurrency = factory(Cryptocurrency::class)->create();
        $userTrade = factory(UserTrade::class)->make([
            'user_id'           => $user->id,
            'cryptocurrency_id' => $cryptocurrency->id,
        ])->toArray();
        $userTrade['traded_at'] = $userTrade['traded_at']->format('Y-m-d H:i:s');

        $response = $this->actingAs($user, 'api')->json('POST', route('api.portfolio.store'), $userTrade);

        $response->assertStatus(201);
        $response->assertJson($userTrade);
    }

    /**
     * Test requireds portfolio store.
     *
     * @return void
     */
    public function testRequiredsPortfolioStore()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', route('api.portfolio.store'), []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'cryptocurrency_id' => [
                    'The cryptocurrency id field is required.',
                ],
                'amount' => [
                    'The amount field is required.',
                ],
                'price_usd' => [
                    'The price usd field is required.',
                ],
                'traded_at' => [
                    'The traded at field is required.',
                ],
            ],
        ]);
    }

    /**
     * Test numerics portfolio store.
     *
     * @return void
     */
    public function testNumericsPortfolioStore()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', route('api.portfolio.store'), [
            'amount'    => 'aaa',
            'price_usd' => 'aaa',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'amount' => [
                    'The amount must be a number.',
                ],
                'price_usd' => [
                    'The price usd must be a number.',
                ],
            ],
        ]);
    }

    /**
     * Test mins portfolio store.
     *
     * @return void
     */
    public function testMinsPortfolioStore()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', route('api.portfolio.store'), [
            'price_usd' => -5,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'price_usd' => [
                    'The price usd must be at least 0.',
                ],
            ],
        ]);
    }

    /**
     * Test date formats portfolio store.
     *
     * @return void
     */
    public function testDateFormatsPortfolioStore()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', route('api.portfolio.store'), [
            'traded_at' => Carbon::now()->format('Y-m-d'),
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'traded_at' => [
                    'The traded at does not match the format Y-m-d H:i:s.',
                ],
            ],
        ]);
    }

    /**
     * Test before or equal portfolio store.
     *
     * @return void
     */
    public function testBeforeOrEqualPortfolioStore()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', route('api.portfolio.store'), [
            'traded_at' => Carbon::now()->addSeconds(60)->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
        ]);
        $response->assertJsonValidationErrors('traded_at');
    }

    /**
     * Test exists on portfolio store.
     *
     * @return void
     */
    public function testExistsOnPortfolioStore()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('POST', route('api.portfolio.store'), [
            'cryptocurrency_id' => 0,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'cryptocurrency_id' => [
                    'The selected cryptocurrency id is invalid.',
                ],
            ],
        ]);
    }
}
