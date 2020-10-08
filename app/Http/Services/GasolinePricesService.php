<?php


namespace App\Http\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GasolinePricesService
{
    /** @var string Constante que contiene la URL base del servicio de precios de gasolina */
    const URL_BASE = 'https://api.datos.gob.mx/v1/precio.gasolina.publico?';

    protected $cp;

    /**
     * GasolinePricesService constructor.
     * @throws RequestException
     */
    public function __construct($cp)
    {
        $this->cp = $cp;
    }

    /**
     * @return Response
     * @throws RequestException
     * @param $page
     * Metodo que consume el servicio de los precios de las gasolinas, así como las coordenas, el servicio contiene un paginado, cuando se
     * pasa la variable $page se entiende que se mostrara la pagina indicada, de lo contrario se retorna todas las paginas.
     */
    public function getAllPrices()
    {
        $cp = http_build_query(['codigopostal' => $this->cp]);
        $response = Http::get(self::URL_BASE.$cp);
        $response->throw();
        return $response;
    }
}
