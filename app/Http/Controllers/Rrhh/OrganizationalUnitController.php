<?php

namespace App\Http\Controllers\Rrhh;

use App\Models\Rrhh\OrganizationalUnit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parameters\OrganizationalUnit\StoreOrganizationalUnitRequest;
use App\Http\Requests\Parameters\OrganizationalUnit\UpdateOrganizationalUnitRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrganizationalUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $ouTree = auth()->user()->organizationalUnit->establishment->ouTree;
    
        // Aplicar la lógica de búsqueda si se proporciona un término de búsqueda
        if ($search) {
            $filteredOuTree = [];
            foreach ($ouTree as $id => $ou) {
                // Filtrar por el término de búsqueda en el nombre
                if (stripos($ou, $search) !== false) {
                    $filteredOuTree[$id] = $ou;
                }
            }
            $ouTree = $filteredOuTree;
        }
    
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
        $organizationalUnit = OrganizationalUnit::where('level', 1)->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)->first();
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

        if($request->input('organizational_unit_id')) {
            $father = OrganizationalUnit::find($request->input('organizational_unit_id'));
            $organizationalUnit->father()->associate($father);
            $organizationalUnit->level = $father->level + 1;
        }

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

    public function createWs(Request $request){
        $responseArray = ['status' => true,'msg' => "Prueba realizada con éxito."];
        return json_encode($responseArray);
    }
}
