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
        $series = RemSerie::orderBy('name')->get();
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
        $serie = RemSerie::firstOrCreate(
            ['name' => $request->name],
            $request->all()
        );
        $serie->save();
        if ($serie->wasRecentlyCreated) {
            session()->flash('info', 'La serie ha sido creada con éxito.');
        } else {
            session()->flash('danger', 'La serie que desea crear ya se encontraba registrada');
        }
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
    public function destroy(RemSerie $serie)
    {
        //        
        $serie->delete();
        session()->flash('success', 'Serie eliminada de REM');

        return redirect()->route('rem.series.index');
    }
}
