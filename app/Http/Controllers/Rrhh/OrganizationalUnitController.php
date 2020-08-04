<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Http\Request;

class OrganizationalUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $organizationalunits = OrganizationalUnit::orderBy('name', 'asc')->get();
        //dd($organizationalunits);
        return view('rrhh.organizationalunit.index', compact('organizationalunits'));        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $organizationalunit = OrganizationalUnit::findOrFail(1);
        return view('rrhh.organizationalunit.create', compact('organizationalunit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organizationalunit = new OrganizationalUnit($request->All());        
        $organizationalunit->save();
        return redirect()->route('rrhh.organizationalunits.index');
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
        
        $organizationalUnits = OrganizationalUnit::All();
        return view('rrhh.organizationalunit.edit', compact('organizationalUnit','organizationalUnits'));
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
        //
        $organizationalUnit->fill($request->all());        
        $organizationalUnit->save();
        return redirect()->route('rrhh.organizationalunits.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationalUnit $organizationalUnit)
    {
        //
    }
}
