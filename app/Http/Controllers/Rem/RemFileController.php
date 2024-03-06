<?php

namespace App\Http\Controllers\Rem;

use App\Http\Controllers\Controller;
use App\Models\Rem\RemFile;
use App\Models\Rem\RemPeriod;
use App\Models\Rem\RemPeriodSerie;
use App\Models\Rem\UserRem;
use App\Models\Establishment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RemFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $folder = 'ionline/rem/';
    public function index(Request $request)
    {
        $now = now()->startOfMonth();

        for ($i = 1; $i <= 7; $i++) {
            $periods[] = $now->clone();
            $now->subMonth('1');
        }

        if (auth()->user()->can('Rem: admin')) {
            $remEstablishments = UserRem::all();
        } else {
            $remEstablishments = auth()->user()->remEstablishments;
        }

        $remFiles = $this->getRemFiles($remEstablishments, $periods);

        /** 
         * Si la cantidad de remFiles es distinta de (establecimientos * periodos)
         * entonces falta crear el periodo actual, acá lo creo 
         **/
        if ($remFiles->count() != count($periods) * $remEstablishments->count()) {
            foreach ($remEstablishments as $remEstablishment) {
                foreach ($periods as $period) {
                    RemFile::FirstOrCreate([
                        'period' => $period->format('Y-m-d'),
                        'establishment_id' => $remEstablishment->establishment_id,
                    ]);
                }
            }
            $remFiles = $this->getRemFiles($remEstablishments, $periods);
        }

        foreach ($remFiles as $remFile) {
            $establishments[$remFile->establishment_id][] = $remFile;
        }


        if (empty($establishments)) {
            session()->flash('danger', 'El usuario no tiene asignados establecimientos para subir REM. Favor contactarse con su encargado para que le asigne en caso que corresponda');
            return redirect()->route('home');
        } else {
            return view('rem.file.index', compact('periods', 'establishments'));
        }
    }

    public function autorizacion_store(Request $request)
    {

        // Valida que el archivo que se está subiendo sea de tipo PDF
        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);

        $data = $request->all();
        $establishment_id = $data['establishment_id'];
        $establishment = Establishment::find($establishment_id);

        //$rem_period_series_id = $data['rem_period_series_id'];
        //$remperiodserie = RemPeriodSerie::find($rem_period_series_id);


        // Creación del archivo con formato personalizado ej: 2022-11_cerro_esmeralda(102-701)_B.pdf */
        $filename = Carbon::parse($data['period'])->format('Y-m') . '_';
        $filename .= Str::snake($establishment->name);
        $filename .= '(' . $establishment->deis . ')_';
        //$filename .= $remperiodserie->serie->name;
        $filename .= '_Autorizacion';
        $filename .= '.' . $request->file->extension();

        // Actualiza o crea un nuevo registro en la tabla RemFiles con los datos proporcionados
        $remFile = RemFile::updateOrCreate(
            [
                'period' => $data['period'],
                //'rem_period_series_id' => $data['rem_period_series_id'],
                'establishment_id' => $data['establishment_id'],
                'type' => 'Autorizacion'
            ],
            [
                'filename' => $this->folder . $filename,
            ]
        );

        // Almacena el archivo en el disco configurado (en este caso, Google Cloud Storage)
        $request->file->storeAs($this->folder, $filename, 'gcs');

        session()->flash('success', 'Autorización de corrección subida exitosamente.');

        // Redirigir a la misma página en la que se encuentra el componente
        return redirect()->route('rem.files.rem_correccion');
    }

    public function rem_original(Request $request)
    {
        $user = auth()->user();
        $remFiles = [];
    
        if ($user->can('Rem: admin')) {
            $remEstablishments = UserRem::all();
        } else {
            $remEstablishments = $user->remEstablishments;
        }
    
        // Obtén la cantidad de meses hacia atrás que se desea mostrar
        $monthsToShow = $request->input('monthsToShow', 0);

    
        $now = now()->startOfMonth();
        $periods_back = [];
    
        // Genera los periodos hacia atrás
        for ($i = 1; $i <= $monthsToShow; $i++) {
            $periods_back[] = $now->clone();
            $now->subMonth('1');
        }
    
        $periods = RemPeriod::whereIn('period', $periods_back)->get();
        $periods_count = $periods->count();
    
        if ($periods_count == 0 and $monthsToShow > 0) {
            session()->flash('danger', 'No hay asignados periodos para el REM, contactar con Departamento de Estadísticas y Gestión de la Información');
        } 
        
        
        if ($periods_count > 0 and $monthsToShow > 0)  {
            $remFiles = $this->getRemFiles($remEstablishments, $periods_back);
        }    
        
        return view('rem.file.rem_original', compact('periods', 'remFiles', 'monthsToShow'));
    }
    

    public function rem_correccion()
    {


        $now = now()->startOfMonth();
        $user = auth()->user();
        $remFiles = [];

        if ($user->can('Rem: admin')) {
            $remEstablishments = UserRem::all();
        } else {
            $remEstablishments = $user->remEstablishments;
        }


        $periods = RemPeriod::all();
        $periods_count = RemPeriod::count();

        if ($periods_count == 0) {
            session()->flash('danger', 'No hay asignado periodos para el REM');
        } else {


            for ($i = 1; $i <= $periods_count; $i++) {
                $periods_back[] = $now->clone();
                $now->subMonth('1');
            }
            $remFiles = $this->getRemFiles($remEstablishments, $periods_back);
        }

        // ...
        // Obtener los archivos de REM


        // Iterar sobre los períodos
        foreach ($periods as $period) {
            // Verificar si existe un archivo en el período correspondiente y de tipo Original
            
            $fileExists = RemFile::
                where('period', $period->period)
                ->whereNotNull('filename')
                ->where('type', 'Original')
                ->first();

                

            // Verificar si existe una autorización en el período correspondiente
            $fileAutorizacion = RemFile::
                where('period', $period->period)
                ->whereNotNull('filename')
                ->where('type', 'Autorizacion')
                ->first();

            // Verificar si existe un archivo de correccion en el período correspondiente
            $fileCorreccion = RemFile::
                where('period', $period->period)
                ->whereNotNull('filename')
                ->where('type', 'Correccion')
                ->first();

            // Almacenar el resultado en un array
            $filesExist[] = $fileExists;
            $filesAutorizacion[] = $fileAutorizacion;
            $filesCorreccion[] = $fileCorreccion;
        }

        return view('rem.file.rem_correccion', compact('periods', 'remFiles', 'filesExist','filesAutorizacion','filesCorreccion',));
    }


    /**
     * getRemFiles, tengo que llamar dos veces a esta query solo en el caso que no exista un perido
     * por eso la dejé fuera
     */
    function getRemFiles($remEstablishments, $periods)
    {
        return RemFile::with('establishment')
            ->whereIn('establishment_id', $remEstablishments->pluck('establishment_id'))
            ->whereDate('period', '<=', $periods[0]->format('Y-m-d'))
            ->whereDate('period', '>=', end($periods)->format('Y-m-d'))
            ->orderBy('establishment_id')
            ->orderBy('period', 'ASC')
            ->get();
    }


    public function download(RemFile $remFile)
    {
        return Storage::disk('gcs')->download($remFile->filename);
    }

    public function destroy(RemFile $remFile)
    {
        $remFile->delete();
        Storage::disk('gcs')->delete($remFile->filename);
        session()->flash('danger', 'Su Archivo ha sido eliminado.');
        // Redirigir a la misma página en la que se encuentra el componente
        return redirect()->route('rem.files.rem_correccion');
        
    }


}
