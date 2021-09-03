<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Models\Parameters\PurchaseMechanism;
use App\Models\Parameters\PurchaseType;
use App\Http\Controllers\Controller;

class PurchaseMechanismController extends Controller
{
    //
    public function index(){
        $purchaseMechanisms = PurchaseMechanism::All();
        $purchaseTypes = PurchaseType::All();
        return view('parameters.purchasemechanisms.index', compact('purchaseMechanisms', 'purchaseTypes'));

    }

    public function create(){
        $purchaseTypes = PurchaseType::All();
        return view('parameters.purchasemechanisms.create', compact('purchaseTypes'));
    }

    public function store(Request $request){
        $purchaseMechanism = new PurchaseMechanism($request->All());
        $purchaseMechanism->save();
        foreach($request->purchaseTypes as $purchaseType){
          $purchaseMechanism->purchaseTypes()->attach($purchaseType);
        }
        session()->flash('info', 'Mecanismo de Compra  '.$purchaseMechanism->name.' ha sido creado.');
        return redirect()->route('parameters.purchasemechanisms.index');
    }

    public function show(PurchaseMechanism $purchaseMechanism){

    }

    public function edit(PurchaseMechanism $purchaseMechanism){
        $lstPurchaseTypes = PurchaseType::All();
        $purchaseTypes = $purchaseMechanism->purchaseTypes()->get();
        return view('parameters.purchasemechanisms.edit', compact('purchaseMechanism', 'lstPurchaseTypes', 'purchaseTypes'));
    }

    public function update(Request $request, PurchaseMechanism $purchaseMechanism){
        $purchaseMechanism->fill($request->all());
        $purchaseMechanism->save();
        $purchaseMechanism->purchaseTypes()->sync($request->purchaseTypes);
        session()->flash('info', 'El Mecanismo de Compra  '.$purchaseMechanism->name.' ha sido actualizado.');
        return redirect()->route('parameters.purchasemechanisms.index');
    }

    public function destroy(PurchaseMechanism $purchaseMechanism){
        //
    }

}
