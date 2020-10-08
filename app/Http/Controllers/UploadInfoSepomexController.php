<?php

namespace App\Http\Controllers;

use App\CargaLayout;
use App\Jobs\UploadInformationDbJob;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadInfoSepomexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return View Sepomex, upload the Excel File.
     */
    public function index()
    {
        $data = CargaLayout::paginate();
        return view('sepomex.index', compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //obtenemos el campo file definido en el formulario
        $file = $request->file('file');

        //obtenemos el nombre del archivo
        $nombre = $file->getClientOriginalName();
        /** @var CargaLayout $carga_layout */
        $carga_layout = $this->saveCargaLayout($nombre);
        $fullPath = $carga_layout->pathLayoutSepomex() . time() . '-' . $nombre;

        $this->createDirectory($carga_layout->pathLayoutSepomex());
        //indicamos que queremos guardar un nuevo archivo en el disco local
        file_put_contents($fullPath, File::get($file));

        //Se procesa Layout mediante un Jon de laravel mandandole como parametro la ruta absoluta del archivo a procesar.
        UploadInformationDbJob::dispatch($fullPath, $carga_layout);

        $notificacion = array(
            'message' => 'Archivo subido correctamente',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notificacion);
    }

    /**
     * @param $nombre
     * @return CargaLayout
     */
    private function saveCargaLayout($nombre)
    {
        /** @var CargaLayout $carga_layout */
        $carga_layout = new CargaLayout();
        $carga_layout->file_name = $nombre;
        $carga_layout->upload_date = Carbon::now()->format('Y-m-d H:i:s');
        $carga_layout->num_data_inserted = 0;
        $carga_layout->loading_status = 'Procesando';
        $carga_layout->save();
        return $carga_layout;
    }

    /**
     * @param $directory
     * Función que crea el directorio en caso que no exista donde se almacenara temporalmente el archivo de CP de SEPOMEX
     */
    private function createDirectory($directory)
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $directory));
            } elseif (!is_writeable($directory)) {
                throw new FileException(sprintf('Unable to write in the "%s" directory', $directory));
            }
        }
    }

}
