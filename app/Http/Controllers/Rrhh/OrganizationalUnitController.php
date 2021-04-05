<?php

namespace App\Http\Controllers\Rrhh;

use App\Rrhh\OrganizationalUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrganizationalUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizationalUnits = OrganizationalUnit::where('level', 1)->where('establishment_id', Auth::user()->organizationalUnit->establishment->id)->get();
        return view('rrhh.organizationalunit.index', compact('organizationalUnits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$organizationalUnit = OrganizationalUnit::find(84);
        $organizationalUnit = OrganizationalUnit::where('level', 1)->where('establishment_id', Auth::user()->organizationalUnit->establishment->id)->first();
        return view('rrhh.organizationalunit.create',compact('organizationalUnit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organizationalUnit = new OrganizationalUnit($request->All());
        $organizationalUnit->father()->associate($request->input('father'));
        $organizationalUnit->save();

        session()->flash('info', 'La unidad organizacional '.$organizationalUnit->name.' ha sido creada.');

        return redirect()->route('rrhh.organizational-units.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationalUnit $organizationalUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationalUnit $organizationalUnit)
    {
        
        $organizationalUnits = OrganizationalUnit::where('establishment_id', $organizationalUnit->establishment_id)->get();
        //$organizationalUnits = OrganizationalUnit::all();
        return view('rrhh/organizationalunit/edit')
            ->withOrganizationalUnit($organizationalUnit)
            ->withOrganizationalUnits($organizationalUnits);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationalUnit $organizationalUnit)
    {
        $organizationalUnit->fill($request->all());
        $organizationalUnit->father()->associate($request->input('father'));
        $organizationalUnit->save();

        session()->flash('info', 'La unidad organizacional '.$organizationalUnit->name.' ha sido actualizada.');

        return redirect()->route('rrhh.organizational-units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationalUnit $organizationalUnit)
    {
        $organizationalUnit->delete();

        session()->flash('success', 'La unidad organizacional '.$organizationalUnit->name.' ha sido eliminada.');

        return redirect()->route('rrhh.organizational-units.index');
    }
}
