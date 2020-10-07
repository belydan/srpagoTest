<?php

namespace Tests\Feature;

use App\Http\Services\GasolinePricesService;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPricesTest()
    {
        $response = new GasolinePricesService();
        $response->getPrices();
        $response->assertStatus(200);
    }
}
