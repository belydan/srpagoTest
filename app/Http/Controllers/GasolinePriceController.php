<?php

namespace App\Http\Controllers;

use App\CpSepomex;
use App\Http\Services\GasolinePricesService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class GasolinePriceController extends Controller
{
    public function getGasolinePrice(Request $request){
        $data = $request->all();
        $cp = CpSepomex::with('toFile');
        $querys = [];
        if (!empty($data['estado'])) {
            $cp->ofEstado($data['estado']);
            $querys['d_estado'] = $data['estado'];
        }

        if (!empty($data['estado'])) {
            $cp->ofMunicipio($data['municipio']);
            $querys['d_mnpio'] = $data['municipio'];
        }

        $cps = $cp->appends($querys)->get();
        $colection = collect($cps);
        $colection->unique('d_cp')->values()->all();

        //Mediante los datos del usuario se intentara encontrar los datos de dirección y precios.
        $this->getDataServicePrice($cp);

    }

    /**
     * @param $cp
     * @return \Illuminate\Http\JsonResponse
     * @throws RequestException
     * Obtiene mediante el servicio de precios de gasolina, los datos de los precios así como de su ubicación
     */
    private function getDataServicePrice($cp){
        $response = new GasolinePricesService($cp);
        try {
            $precios = $response->getAllPrices();
        } catch (RequestException $e) {
            throw new \Exception("Existio un error al obtener la información del servicio: ",$e->getMessage());
        }
        json_decode($precios->body())->results;
        return response()->json();
    }
}
