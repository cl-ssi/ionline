<?php

namespace App\Http\Controllers\Pharmacies;

use App\Pharmacies\PurchaseItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pharmacies\Product;

class PurchaseItemController extends Controller
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
          'amount' => 'required|numeric',
          'unit_cost' => 'required|numeric'
      ]);

      $PurchaseItem = new PurchaseItem($request->all());
      $PurchaseItem->save();

      $product = Product::find($request->product_id);
      $product->stock = $product->stock + $request->amount;
      $product->save();

      session()->flash('success', 'Se ha guardado el detalle del ingreso.');
      return redirect()->route('pharmacies.products.purchase.show', $PurchaseItem->purchase);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacies\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacies\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacies\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacies\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseItem $purchaseItem)
    {
      $product = Product::find($purchaseItem->product_id);
      $product->stock = $product->stock - $purchaseItem->amount;
      $product->save();

      $purchase = $purchaseItem->purchase;
      $purchaseItem->delete();
      session()->flash('success', 'Se ha eliminado el ítem.');
      return redirect()->route('pharmacies.products.purchase.show', $purchase);
    }
}
