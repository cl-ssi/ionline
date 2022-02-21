<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\PoliceUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoliceUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policeUnits = PoliceUnit::All()->SortBy('name');
        return view('drugs.police_units.index')->withPoliceUnits($policeUnits);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drugs/police_units/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $policeUnits = new PoliceUnit($request->All());
      $policeUnits->save();
      return redirect()->route('drugs.police_units.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\PoliceUnit  $policeUnit
     * @return \Illuminate\Http\Response
     */
    public function show(PoliceUnit $policeUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\PoliceUnit  $policeUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(PoliceUnit $policeUnit)
    {
        return view('drugs/police_units/edit')->withPoliceUnit($policeUnit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drugs\PoliceUnit  $policeUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PoliceUnit $policeUnit)
    {
      $policeUnit->fill($request->all());
      $policeUnit->save();
      return redirect()->route('drugs.police_units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drugs\PoliceUnit  $policeUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(PoliceUnit $policeUnit)
    {
        //
    }
}
