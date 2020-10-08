<?php

namespace Tests\Feature;

use App\Http\Services\GasolinePricesService;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
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

    /**
     * @return Response
     * @throws Exception
     */
    public function testPricesTest()
    {
        $response = new GasolinePricesService('25736');
        try {
            $precios = $response->getAllPrices();
        } catch (RequestException $e) {
            throw new Exception("Existio un error al obtener la información del servicio: ",$e->getMessage());
        }
        return json_decode($precios->body())->results;
        //$response->assertStatus(200);
    }
}
