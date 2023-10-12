<?php

namespace App\Http\Controllers\Rrhh;

use App\Rrhh\OrganizationalUnit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parameters\OrganizationalUnit\StoreOrganizationalUnitRequest;
use App\Http\Requests\Parameters\OrganizationalUnit\UpdateOrganizationalUnitRequest;
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
        $ouTree = auth()->user()->organizationalUnit->establishment->ouTree;
        return view('rrhh.organizationalunit.index', compact('ouTree'));
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
     * @param  StoreOrganizationalUnitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganizationalUnitRequest $request)
    {
        $organizationalUnit = new OrganizationalUnit($request->validated());
        $father = OrganizationalUnit::find($request->input('organizational_unit_id'));
        $organizationalUnit->father()->associate($father);
        $organizationalUnit->level = $father->level + 1;
        /** Limpia que no tenga doble espacios */
        $organizationalUnit->name = preg_replace('/\s+/', ' ', $organizationalUnit->name);
        $organizationalUnit->save();

        session()->flash('info', 'La unidad organizacional '.$organizationalUnit->name.' ha sido creada.');

        return redirect()->route('rrhh.organizational-units.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationalUnit $organizationalUnit)
    {
        return view('rrhh/organizationalunit/edit')
            ->withOrganizationalUnit($organizationalUnit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrganizationalUnitRequest  $request
     * @param  OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationalUnitRequest $request, OrganizationalUnit $organizationalUnit)
    {
        $organizationalUnit->fill($request->validated());
        /** Limpia que no tenga doble espacios */
        $organizationalUnit->name = preg_replace('/\s+/', ' ', $organizationalUnit->name);

        $father = OrganizationalUnit::find($request->input('organizational_unit_id'));
        $organizationalUnit->father()->associate($father);
        $organizationalUnit->level = $father->level + 1;

        $organizationalUnit->save();

        session()->flash('info', 'La unidad organizacional '.$organizationalUnit->name.' ha sido actualizada.');

        return redirect()->route('rrhh.organizational-units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrganizationalUnit  $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationalUnit $organizationalUnit)
    {
        $organizationalUnit->delete();

        session()->flash('success', 'La unidad organizacional '.$organizationalUnit->name.' ha sido eliminada.');

        return redirect()->route('rrhh.organizational-units.index');
    }
}
