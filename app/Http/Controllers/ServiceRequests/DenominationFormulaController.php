<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequests\DenominationFormula;

class DenominationFormulaController extends Controller
{

    public function index()
    {
        $denominationsFormula = DenominationFormula::All();
        return view('service_requests.parameters.formula.index', compact('denominationsFormula'));
    }


    public function create()
    {
        return view('service_requests.parameters.formula.create');
    }


    public function store(Request $request)
    {
        $denominationsFormula = new DenominationFormula($request->All());
        $denominationsFormula->save();

        session()->flash('info', 'El registro  '.$denominationsFormula->code.' ha sido creado.');

        return redirect()->route('rrhh.service-request.parameters.formula.index');
    }


    public function show(Location $location)
    {

    }


    public function edit(DenominationFormula $denominationFormula)
    {
        return view('service_requests.parameters.formula.edit', compact('denominationFormula'));
    }


    public function update(Request $request, DenominationFormula $denominationFormula)
    {
        $denominationFormula->fill($request->all());
        $denominationFormula->save();

        session()->flash('info', 'El Registro  '.$denominationFormula->code.' ha sido actualizado.');

        return redirect()->route('rrhh.service-request.parameters.formula.index');
    }


    public function destroy(Location $location)
    {
        //
    }

}
