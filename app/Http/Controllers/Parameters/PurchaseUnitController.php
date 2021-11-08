<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Models\Parameters\PurchaseUnit;
use App\Http\Controllers\Controller;

class PurchaseUnitController extends Controller
{
    //
    public function index(){
        $purchaseUnits = PurchaseUnit::All();
        return view('parameters.purchaseunits.index', compact('purchaseUnits'));
    }

    public function create(){
        return view('parameters.purchaseunits.create');
    }

    public function store(Request $request){
        $purchaseUnit = new PurchaseUnit($request->All());
        $purchaseUnit->save();

        session()->flash('info', 'Unidad de Compra  '.$purchaseUnit->name.' ha sido creado.');

        return redirect()->route('parameters.purchaseunits.index');
    }

    public function show(PurchaseUnit $purchaseUnit){

    }

    public function edit(PurchaseUnit $purchaseUnit){
        return view('parameters.purchaseunits.edit', compact('purchaseUnit'));
    }

    public function update(Request $request, PurchaseUnit $purchaseUnit){
        $purchaseUnit->fill($request->all());
        $purchaseUnit->save();

        session()->flash('info', 'La Unida de Compra  '.$purchaseUnit->name.' ha sido actualizado.');

        return redirect()->route('parameters.purchaseunits.index');
    }

    public function destroy(PurchaseType $purchaseUnit){
        //
    }
}
