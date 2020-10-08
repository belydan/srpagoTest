@extends('layout.master')
@section('content')
    <img id="carga" src="img/carga.gif" class="loader"/>
    <div class="page-header">
        <h1>Precios de Gasolina Por Estado</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">BUSQUEDA POR ESTADO</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tipo_comprobante" class="required">Estado</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-list"></span></div>
                                <select class="form-control" name="estado" id="estado" required>
                                    @foreach($estados as $estado)
                                        <option
                                            value="{{$estado->c_estado}}">{{$estado->d_estado}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tipo_comprobante" class="required">Municipio</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-list"></span></div>
                                <select class="form-control" name="municipio" id="municipio" required></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tipo_comprobante" class="required">Ord. de precio de conbustible</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></div>
                                <select class="form-control" name="orden" id="orden" required>
                                    <option value="asc">Ascendente</option>
                                    <option value="desc">Descendente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary pull-right" id="buscar">Buscar</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover" id="table-data">
                <thead>
                    <th>Dirección</th>
                    <th>Precio gas Regular</th>
                    <th>Precio gas Premium</th>
                    <th>Precio gas Diesel</th>
                    <th>Ubicacion Latitud</th>
                    <th>Ubicacion Longitud</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
    <script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/examples.css')}}" />
    <script type="text/javascript" src="{{asset('js/home.js')}}"></script>

@endsection
