<?php

namespace App\Http\Controllers\Rem;

use App\Models\Rem\RemPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class RemPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $periods = RemPeriod::all();
        return view('rem.period.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('rem.period.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $period = RemPeriod::firstOrCreate(
            ['year' => $request->year, 'month' => $request->month],
            $request->all()
        );
        $period->period = \Carbon\Carbon::createFromFormat('Y-m-d', $request->year . "-" . $request->month . "-1");
        $period->save();
        if ($period->wasRecentlyCreated) {
            session()->flash('info', 'Se ha sido creado el Periodo correctamente.');
        } else {
            session()->flash('danger', 'El periodo que desea crear ya se encontraba registrado');
        }
        return redirect()->route('rem.periods.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(RemPeriod $remPeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(RemPeriod $remPeriod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RemPeriod $remPeriod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemPeriod $period)
    {
        if ($period->series->count() > 0) {
            return redirect()->route('rem.periods.index')->with('warning', 'No se puede eliminar el período ya que tiene REM asociados.');
        }
    
        $period->forceDelete();
        return redirect()->route('rem.periods.index')->with('success', 'Período de REM eliminado correctamente.');
    }
    
}
