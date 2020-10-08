<?php

namespace App\Http\Controllers;

use App\CpSepomex;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $estados = CpSepomex::get()->unique('c_estado');
        return view('home.index',compact('estados'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMunicipios(Request $request){
        $c_estado = $request->get('c_estado');
        $municipios = CpSepomex::query()->where('c_estado',$c_estado)->get()->unique('c_mnpio');
        return $municipios;
    }
}
