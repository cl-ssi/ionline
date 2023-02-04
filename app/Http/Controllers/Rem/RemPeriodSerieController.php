<?php

namespace App\Http\Controllers\Rem;

use App\Http\Controllers\Controller;

use App\Models\Rem\RemPeriodSerie;
use App\Models\Rem\RemSerie;
use App\Models\Rem\RemPeriod;
use Illuminate\Http\Request;


class RemPeriodSerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $remPeriodSeries = RemPeriodSerie::all();
        return view('rem.period_serie.index', compact('remPeriodSeries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $remSeries = RemSerie::orderBy('name')->get();
        $remPeriods = RemPeriod::all();
        return view('rem.period_serie.create', compact('remSeries', 'remPeriods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRemPeriodSerieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        foreach ($request->type as $type) {
            $data[] = [
                'period_id' => $request->period_id,
                'serie_id' => $request->serie_id,
                'type' => $type
            ];
        }
        RemPeriodSerie::insert($data);
        session()->flash('info', 'La serie ha sido creada con éxito');
        return redirect()->route('rem.periods_series.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rem\RemPeriodSerie  $remPeriodSerie
     * @return \Illuminate\Http\Response
     */
    public function show(RemPeriodSerie $remPeriodSerie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rem\RemPeriodSerie  $remPeriodSerie
     * @return \Illuminate\Http\Response
     */
    public function edit(RemPeriodSerie $remPeriodSerie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRemPeriodSerieRequest  $request
     * @param  \App\Models\Rem\RemPeriodSerie  $remPeriodSerie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRemPeriodSerieRequest $request, RemPeriodSerie $remPeriodSerie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rem\RemPeriodSerie  $remPeriodSerie
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemPeriodSerie $remPeriodSerie)
    {
        //
    }
}
