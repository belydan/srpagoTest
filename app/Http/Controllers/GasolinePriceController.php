<?php

namespace App\Http\Controllers;

use App\CpSepomex;
use App\Http\Services\GasolinePricesService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class GasolinePriceController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws RequestException
     */
    public function getGasolinePrice(Request $request)
    {
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

        $cp = $cp->paginate(100000);

        $cps = $cp->appends($querys);
        foreach ($cps->all() as $cp) {
            //Mediante los datos del usuario se intentara encontrar los datos de dirección y precios.
            $dataService = $this->getDataServicePrice($cp->cp);

            $response['estado'] = $data['estado'];
            $response['municipio'] = $data['municipio'];
            $response['order'] = $data['order'];

            foreach ($dataService->getData() as $precios) {
                $direccion = $precios->calle . " Col." . $precios->colonia;
                $ubicacion = ['longitud' => $precios->longitude, 'latitude' => $precios->latitude];
                $precios = ['regular' => $precios->regular, 'premium' => $precios->premium, 'diesel' => $precios->dieasel];
                $response['info'][] = [
                    'direccion' => $direccion,
                    'precios' => $precios,
                    'ubicacion' => $ubicacion
                ];
            }
        }
        $colletion = collect($response);
        if(!empty($response['order']) && $response['order'] === 'desc'){
            $response = $colletion->sortByDesc("info.precios.regular")->toArray();
        }else{
            $response = $colletion->sortBy("info.precios.regular")->toArray();
        }
        return response()->json($response);
    }

    /**
     * @param $cp
     * @return \Illuminate\Http\JsonResponse
     * @throws RequestException
     * Obtiene mediante el servicio de precios de gasolina, los datos de los precios así como de su ubicación
     */
    private function getDataServicePrice($cp)
    {
        $response = new GasolinePricesService($cp);
        try {
            $precios = $response->getAllPrices();
        } catch (RequestException $e) {
            throw new \Exception("Existio un error al obtener la información del servicio: ", $e->getMessage());
        }
        $precios = json_decode($precios->body())->results;
        return response()->json($precios);
    }
}
