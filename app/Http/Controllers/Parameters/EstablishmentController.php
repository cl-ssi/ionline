<?php

namespace App\Http\Controllers\Parameters;

use App\Models\Establishment;
use App\Models\Commune;
use App\Models\HealthService;
use App\Models\Parameters\EstablishmentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $establishments = Establishment::with('commune','establishmentType')->get();
        return view('parameters.establishments.index', compact('establishments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $establishmentTypes = EstablishmentType::all();
        $communes = Commune::all();
        $healthServices = HealthService::all();
        return view('parameters/establishments/create', compact('establishmentTypes', 'communes', 'healthServices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $establishment = new Establishment($request->All());
        $establishmentType = EstablishmentType::find($request->establishment_type_id);
        $establishment->type = $establishmentType->name;
        $establishment->save();
        session()->flash('success', 'Establecimiento creado exitosamente');
        return redirect()->route('parameters.establishments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function show(Establishment $establishment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function edit(Establishment $establishment)
    {
        //
        $establishmentTypes = EstablishmentType::all();
        $communes = Commune::all();
        $healthServices = HealthService::all();
        return view('parameters/establishments/edit', compact('establishmentTypes', 'communes', 'healthServices', 'establishment'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establishment $establishment)
    {
        $establishment->fill($request->all());
        $establishmentType = EstablishmentType::find($request->establishment_type_id);
        $establishment->type = $establishmentType->name;
        $establishment->save();

        session()->flash('info', 'El establecimiento ' . $establishment->name . ' ha sido editado.');
        return redirect()->route('parameters.establishments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establishment $establishment)
    {
        //

    }
}
