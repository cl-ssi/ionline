<?php

namespace App\Http\Controllers\Parameters;

use App\Models\Parameters\EstablishmentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstablishmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $establishmentTypes = EstablishmentType::orderBy('name', 'asc')->get();
        return view('parameters.establishmenttypes.index', compact('establishmentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('parameters.establishmenttypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $establishmentType = EstablishmentType::firstOrCreate(['name' => $request->name]);
        if ($establishmentType->wasRecentlyCreated) {
            session()->flash('success', 'Tipo de Establecimiento creado exitosamente');
        } else {
            session()->flash('warning', 'Tipo de Establecimiento ya existe en la Base De Datos');
        }
        return redirect()->route('parameters.establishment_types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameters\EstablishmentType  $establishmentType
     * @return \Illuminate\Http\Response
     */
    public function show(EstablishmentType $establishmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parameters\EstablishmentType  $establishmentType
     * @return \Illuminate\Http\Response
     */
    public function edit(EstablishmentType $establishmentType)
    {
        //
        return view('parameters.establishmenttypes.edit', compact('establishmentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parameters\EstablishmentType  $establishmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstablishmentType $establishmentType)
    {
        $request->validate([
            'name' => 'required|unique:establishment_types,name,' . $establishmentType->id,
        ]);

        $establishmentType->name = $request->name;
        $establishmentType->save();

        session()->flash('success', 'Tipo de Establecimiento actualizado exitosamente');
        return redirect()->route('parameters.establishment_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameters\EstablishmentType  $establishmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstablishmentType $establishmentType)
    {
        //
    }
}
