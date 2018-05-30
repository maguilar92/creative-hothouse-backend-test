<?php

namespace Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Cryptocurrency\Entities\Cryptocurrency;
use Tests\TestCase;

class CryptocurrencyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test cryptocurrency index.
     *
     * @return void
     */
    public function testCryptocurrencyIndex()
    {
        $cryptocurrencies = factory(Cryptocurrency::class, 25)->create();

        $response = $this->get(route('api.coins.index'));

        $response->assertStatus(200);
        $response->assertJson([
            'total' => 25,
        ]);
        $response->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
    }

    /**
     * Test existing cryptocurrency show.
     *
     * @return void
     */
    public function testExistingCryptocurrencyShow()
    {
        $cryptocurrency = factory(Cryptocurrency::class)->create();

        $response = $this->get(route('api.coins.show', $cryptocurrency->id));

        $response->assertStatus(200);
        $response->assertJson([
            'name' => $cryptocurrency->name,
            'rank' => $cryptocurrency->rank,
        ]);
    }

    /**
     * Test unexisting cryptocurrency show.
     *
     * @return void
     */
    public function testUnexistingCryptocurrencyShow()
    {
        $response = $this->get(route('api.coins.show', 0));

        $response->assertStatus(404);
    }
}
