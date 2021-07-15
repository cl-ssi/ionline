<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Models\Parameters\PurchaseMechanism;
use App\Http\Controllers\Controller;

class PurchaseMechanismController extends Controller
{
    //
    public function index(){
        $purchaseMechanisms = PurchaseMechanism::All();
        return view('parameters.purchasemechanisms.index', compact('purchaseMechanisms'));
    }

    public function create(){
        return view('parameters.purchasemechanisms.create');
    }

    public function store(Request $request){
        $purchaseMechanism = new PurchaseMechanism($request->All());
        $purchaseMechanism->save();

        session()->flash('info', 'Mecanismo de Compra  '.$purchaseMechanism->name.' ha sido creado.');

        return redirect()->route('parameters.purchasemechanisms.index');
    }

    public function show(PurchaseMechanism $purchaseMechanism){

    }

    public function edit(PurchaseMechanism $purchaseMechanism){
        return view('parameters.purchasemechanisms.edit', compact('purchaseMechanism'));
    }

    public function update(Request $request, PurchaseMechanism $purchaseMechanism){
        $purchaseMechanism->fill($request->all());
        $purchaseMechanism->save();

        session()->flash('info', 'El Mecanismo de Compra  '.$purchaseMechanism->name.' ha sido actualizado.');

        return redirect()->route('parameters.purchasemechanisms.index');
    }

    public function destroy(PurchaseMechanism $purchaseMechanism){
        //
    }
    
}
