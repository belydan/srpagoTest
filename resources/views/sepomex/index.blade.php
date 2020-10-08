@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Importación C.P Sepomex</div>
                    <div class="panel-body">
                        <form method="POST" action="{{route('upload.info.file')}}"
                              accept-charset="UTF-8" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nuevo Archivo</label>
                                <div class="col-md-7">
                                    <input type="file" class="form-control" name="file"> <br>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary">Procesar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td><strong>Id</strong></td>
                            <td><strong>Nombre archivo</strong></td>
                            <td><strong>Fecha de carga</strong></td>
                            <td><strong>Num. Registros</strong></td>
                            <td><strong>Fecha Ultima Actualización</strong></td>
                            <td><strong>Estatus</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $dato)
                            <tr {!! $dato->loading_status != "Terminado" ? 'class="danger"' : 'class="success"' !!}>
                                <td>{{ $dato->id }}</td>
                                <td>{{ $dato->file_name }}</td>
                                <td>{{ $dato->upload_date }}</td>
                                <td>{{ $dato->num_data_inserted }}</td>
                                <td>{{ $dato->updated_at }}</td>
                                <td>{{ $dato->loading_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No existen layouts cargados.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {!! $data->render() !!}
            </div>
        </div>
    </div>

    <script src="{{ asset('js/cargaLayouts/layouts.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
            @endif
            $("#info").hide();
        });
    </script>
@endsection
