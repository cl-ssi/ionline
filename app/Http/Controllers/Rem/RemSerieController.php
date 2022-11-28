<?php

namespace App\Http\Controllers\Rem;

use App\Models\Rem\RemSerie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class RemSerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $series = RemSerie::all();
        return view('rem.serie.index', compact('series'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('rem.serie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRemSerieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $remSerie = new RemSerie($request->all());
        $remSerie->save();
        session()->flash('info', 'La serie ha sido creada con éxito');
        return redirect()->route('rem.series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rem\RemSerie  $remSerie
     * @return \Illuminate\Http\Response
     */
    public function show(RemSerie $remSerie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rem\RemSerie  $remSerie
     * @return \Illuminate\Http\Response
     */
    public function edit(RemSerie $remSerie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRemSerieRequest  $request
     * @param  \App\Models\Rem\RemSerie  $remSerie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRemSerieRequest $request, RemSerie $remSerie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rem\RemSerie  $remSerie
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemSerie $remSerie)
    {
        //
    }
}
