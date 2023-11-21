<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rrhh\Absenteeism;
use App\Models\Rrhh\AbsenteeismType;

class AbsenteeismTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $absenteeismTypes = AbsenteeismType::all();
        return view('rrhh.abseentism_types.index', compact('absenteeismTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $distinctTypes = Absenteeism::distinct('tipo_de_ausentismo')->pluck('tipo_de_ausentismo')->toArray();

        // Obtener los tipos de ausentismo que no están en el modelo AbsenteeismType
        $typesnotstore = array_diff($distinctTypes, AbsenteeismType::pluck('name')->toArray());

        return view('rrhh.abseentism_types.create', compact('typesnotstore'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar el formulario si es necesario
        $request->validate([
            'tipo_de_ausentismo' => 'required|string|max:255',
        ]);

        $tipoDeAusentismo = $request->input('tipo_de_ausentismo');
        AbsenteeismType::create(['name' => $tipoDeAusentismo]);
        return redirect()->route('rrhh.absence-types.index')->with('success', 'Tipo de ausentismo agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validar el formulario si es necesario
        $request->validate([
            'discount' => 'nullable|boolean',
            'half_day' => 'nullable|boolean',
            'count_business_days' => 'nullable|boolean',
        ]);

        $absenteeismType = AbsenteeismType::findOrFail($id);
        $absenteeismType->update([
            'discount' => $request->has('discount'),
            'half_day' => $request->has('half_day'),
            'count_business_days' => $request->has('count_business_days'),
            'over' => $request->input('over'),
            'from' => $request->input('from'),
        ]);

        return redirect()->route('rrhh.absence-types.index')->with('success', 'Tipo de ausentismo actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
