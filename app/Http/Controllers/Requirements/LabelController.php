<?php

namespace App\Http\Controllers\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Parameters\Location;
use App\Requirements\Label;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::All();
        return view('requirements.labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        return view('requirements.labels.create', compact('ouRoots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $label = new Label($request->All());
        $label->save();

        session()->flash('info', 'La etiqueta  '.$label->name.' ha sido creada.');

        return redirect()->route('requirements.labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requirements\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        return view('requirements.labels.edit', compact('label', 'ouRoots'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requirements\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $label->fill($request->all());
        $label->save();

        session()->flash('info', 'La etiqueta  '.$label->name.' ha sido actualizada.');

        return redirect()->route('requirements.labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
