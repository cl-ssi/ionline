<?php

namespace App\Http\Controllers\Parameters;

use App\Http\Controllers\Controller;
use App\Models\Parameters\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $professions = Profession::All();
        return view('parameters.professions.index', compact('professions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('parameters.professions.create');
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
        $profession = new Profession($request->All());
        $profession->save();
        session()->flash('success', 'Profesión Creada');
        return redirect()->route('parameters.professions.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paramaters\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paramaters\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function edit(Profession $profession)
    {
        return view('parameters.professions.edit', compact('profession'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paramaters\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profession $profession)
    {
        //
        $profession->fill($request->all());
        $profession->save();
        session()->flash('success', 'Profesión: '.$profession->name.' ha sido actualizado.');
        return redirect()->route('parameters.professions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paramaters\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professional $professional)
    {
        //
    }
}
