<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\School;
use App\Models\Commune;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $schools = School::orderBy('name')->get();;
        return view('suitability.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $communes = Commune::All()->SortBy('name');
        return view('suitability.schools.create', compact('communes'));
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
        $school = new School($request->All());
        $school->save();
        session()->flash('success', 'Colegio Creado Exitosamente');
        return redirect()->route('suitability.schools.index');
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
    public function edit(School $school)
    {
        //
        $communes = Commune::All()->SortBy('name');
        return view('suitability.schools.edit', compact('school', 'communes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        //        
        $school->fill($request->all());
        $school->save();
        session()->flash('success', 'Colegio Actualizado Exitosamente');
        return redirect()->route('suitability.schools.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($school)
    {
        //
        $school = School::find($school);
        $school->delete();
        session()->flash('success', 'Colegio eliminado exitosamente');        
        return redirect()->route('suitability.schools.index');
    }
}
