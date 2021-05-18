<?php

namespace App\Http\Controllers\Pharmacies;

use App\Pharmacies\DispatchItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\Dispatch;
use App\Pharmacies\Product;

class DispatchItemController extends Controller
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

      // obtiene valores
      $values = explode(" - ", $request->due_date_batch);

      $DispatchItem = new DispatchItem($request->all());
      $DispatchItem->due_date = $values[0];
      $DispatchItem->batch = $values[1];
      $DispatchItem->save();

      $product = Product::find($request->product_id);
      $product->stock = $product->stock - $request->amount;
      $product->save();

      if($product->program_id == 46){ //APS ORTESIS
        $product->load('establishments');
        $establishment_id = Dispatch::find($request->dispatch_id)->establishment_id;
        $pass = false;
        foreach($product->establishments as $establishment)
          if($establishment->id == $establishment_id){
              $establishment->pivot->increment('stock', $request->amount);
              $pass = true;
          }
        if(!$pass){
          $product->establishments()->attach($establishment_id, ['stock' => $request->amount]);
        }
      }

      session()->flash('success', 'Se ha guardado el detalle del egreso.');
      return redirect()->route('pharmacies.products.dispatch.show', $DispatchItem->dispatch);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacy\DispatchItem  $dispatchItem
     * @return \Illuminate\Http\Response
     */
    public function show(DispatchItem $dispatchItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy\DispatchItem  $dispatchItem
     * @return \Illuminate\Http\Response
     */
    public function edit(DispatchItem $dispatchItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy\DispatchItem  $dispatchItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DispatchItem $dispatchItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy\DispatchItem  $dispatchItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(DispatchItem $dispatchItem)
    {
      $product = Product::find($dispatchItem->product_id);
      $product->stock = $product->stock + $dispatchItem->amount;
      $product->save();

      if($product->program_id == 46){ //APS ORTESIS
        $product->load('establishments');
        $establishment_id = Dispatch::find($dispatchItem->dispatch_id)->establishment_id;
        $pass = false;
        foreach($product->establishments as $establishment)
          if($establishment->id == $establishment_id){
              $establishment->pivot->decrement('stock', $dispatchItem->amount);
              $pass = true;
          }
        if(!$pass){
          $product->establishments()->attach($establishment_id, ['stock' => -$dispatchItem->amount]);
        }
      }

      $dispatch = $dispatchItem->dispatch;
      $dispatchItem->delete();
      session()->flash('success', 'Se ha eliminado el ítem.');
      return redirect()->route('pharmacies.products.dispatch.show', $dispatch);
    }
}
