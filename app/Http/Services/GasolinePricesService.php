<?php


namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class GasolinePricesService
{
    public function getPrices(){
        $response = Http::get('https://api.datos.gob.mx/v1/precio.gasolina.publico');
    }


}
