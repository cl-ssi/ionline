<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\Product;

class ReceivingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'barcode' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        if(!$request->unity){
            session()->flash('warning', 'Algunos datos no han sido reconocidos para registrar el movimiento. Actualice e intente nuevamente.');
            return redirect()->back();
        }
        
        $ReceivingItem = new ReceivingItem($request->all());
        $ReceivingItem->save();

        $product = Product::find($request->product_id);
        $product->stock = $product->stock + $request->amount;
        $product->name = $request->name;
        $product->barcode = $request->barcode;
        $product->save();

        session()->flash('success', 'Se ha guardado el detalle del ingreso.');
        return redirect()->route('pharmacies.products.receiving.show', $ReceivingItem->receiving);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacy\ReceivingItem  $receivingItem
     * @return \Illuminate\Http\Response
     */
    public function show(ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy\ReceivingItem  $receivingItem
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy\ReceivingItem  $receivingItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy\ReceivingItem  $receivingItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceivingItem $receivingItem)
    {
        $product = Product::find($receivingItem->product_id);
        if($product){
            $product->stock = $product->stock - $receivingItem->amount;
            $product->save();

            $receiving = $receivingItem->receiving;
            $receivingItem->delete();

            session()->flash('success', 'Se ha eliminado el ítem.');
            return redirect()->route('pharmacies.products.receiving.show', $receiving);
        }else{
            session()->flash('warning', 'No se ha encontrado el producto que se intenta eliminar.');
            return redirect()->route('pharmacies.products.receiving.show', $receiving);
        }
        
    }
}
