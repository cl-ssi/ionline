<?php

namespace App\Http\Controllers\Rem;
use App\Http\Controllers\Controller;

use App\Models\Rem\RemPeriodSerie;


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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRemPeriodSerieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRemPeriodSerieRequest $request)
    {
        //
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
