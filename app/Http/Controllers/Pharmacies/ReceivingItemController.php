<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\ReceivingItem;
use App\Pharmacies\Product;

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
          'barcode' => 'required|integer',
          'amount' => 'required|numeric'
      ]);


      $ReceivingItem = new ReceivingItem($request->all());
      $ReceivingItem->save();

      $product = Product::find($request->product_id);
      $product->stock = $product->stock + $request->amount;
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
      $product->stock = $product->stock - $receivingItem->amount;
      $product->save();

      $receiving = $receivingItem->receiving;
      $receivingItem->delete();

      session()->flash('success', 'Se ha eliminado el ítem.');
      return redirect()->route('pharmacies.products.receiving.show', $receiving);
    }
}
