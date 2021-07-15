<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Models\Parameters\PurchaseType;
use App\Http\Controllers\Controller;


class PurchaseTypeController extends Controller
{
    //
    public function index(){
        $purchaseTypes = PurchaseType::All();
        return view('parameters.purchasetypes.index', compact('purchaseTypes'));
    }

    public function create(){
        return view('parameters.purchasetypes.create');
    }

    public function store(Request $request){
        $purchaseType = new PurchaseType($request->All());
        $purchaseType->save();

        session()->flash('info', 'Tipo de Compra  '.$purchaseType->name.' ha sido creado.');

        return redirect()->route('parameters.purchasetypes.index');
    }

    public function show(PurchaseType $purchaseType){

    }

    public function edit(PurchaseType $purchaseType){
        return view('parameters.purchasetypes.edit', compact('purchaseType'));
    }

    public function update(Request $request, PurchaseType $purchaseType){
        $purchaseType->fill($request->all());
        $purchaseType->save();

        session()->flash('info', 'El Tipo de Compra  '.$purchaseType->name.' ha sido actualizado.');

        return redirect()->route('parameters.purchasetypes.index');
    }

    public function destroy(PurchaseType $purchaseType){
        //
    }

}
