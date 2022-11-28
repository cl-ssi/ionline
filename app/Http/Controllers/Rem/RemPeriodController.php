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
        $remPeriod = RemPeriod::where('year', $request->year)->where('month', $request->month)->first();
        if ($remPeriod == NULL) {
            $remPeriod = new RemPeriod($request->all());
            $period = \Carbon\Carbon::createFromFormat('Y-m-d', $request->year . "-" . $request->month . "-1");
            $remPeriod->period = $period;
            $remPeriod->save();
            session()->flash('info', 'Se ha sido creado el Periodo correctamente.');
            return redirect()->route('rem.periods.index');
        } 
        else {
            session()->flash('danger', 'El periodo que desea crear ya se encontraba registrado');
            return redirect()->route('rem.periods.index');
        }
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
    public function destroy(RemPeriod $remPeriod)
    {
        //
    }
}
