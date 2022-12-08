<?php

namespace App\Http\Controllers\Rem;

use App\Http\Controllers\Controller;
use App\Models\Rem\RemFile;
use App\Models\Rem\RemPeriod;
use App\Models\Rem\UserRem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class RemFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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


        if (empty($establishments)) 
        {            
            session()->flash('danger', 'El usuario no tiene asignados establecimientos para subir REM. Favor contactarse con su encargado para que le asigne en caso que corresponda');
            return redirect()->route('home');
        }

        else 
        {
            return view('rem.file.index', compact('periods', 'establishments'));
        }
    }

    public function index_2()
    {
        $now = now()->startOfMonth();
        $user = auth()->user();
    
        if ($user->can('Rem: admin')) {
            $remEstablishments = UserRem::all();
        } else {
            $remEstablishments = $user->remEstablishments;
        }


        $periods = RemPeriod::all();
        $periods_count = RemPeriod::count();

        if($periods_count==0)
        {
            session()->flash('danger', 'No hay asignado periodos para el REM');
            return redirect()->route('home');

        }


        //dd($periods_count);


        for ($i = 1; $i <=$periods_count; $i++) {
            $periods_back[] = $now->clone();
            $now->subMonth('1');
        }
        $remFiles = $this->getRemFiles($remEstablishments, $periods_back);
        
        
        return view('rem.file.index_2', compact('periods','remFiles'));
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


    public function store(Request $request)
    {
        dd('entre al store');

    }




}
