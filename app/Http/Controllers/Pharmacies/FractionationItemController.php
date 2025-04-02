<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Fractionation;
use App\Models\Pharmacies\FractionationItem;
use App\Models\Pharmacies\Product;
use App\Models\Pharmacies\Batch;

class FractionationItemController extends Controller
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
            'amount' => 'required|numeric',
            'product_id' => 'required'
        ]);

        // obtiene valores
        $values = explode(" - ", $request->due_date_batch);

        $batch = Batch::where('product_id',$request->product_id)->where('due_date',$values[0])->where('batch',$values[1])->first();
        if($batch){
            if($request->amount > $batch->count){
                session()->flash('warning', 'El monto que se intenta fraccionar es superior al disponible.');
                return redirect()->back();
            }
        }else{
            session()->flash('warning', 'No se encontró stock del lote seleccionado.');
            return redirect()->back();
        }

        $fractionationItem = new FractionationItem($request->all());
        $fractionationItem->due_date = $values[0];
        $fractionationItem->batch = $values[1];
        $fractionationItem->save();

        $product = Product::find($request->product_id);
        $product->stock = $product->stock - $request->amount;
        $product->save();

        if($product->program_id == 46){ //APS ORTESIS
            $product->load('destines');
            $destiny_id = Fractionation::find($request->fractionation_id)->destiny_id;
            $pass = false;
            foreach($product->destines as $destiny)
            if($destiny->id == $destiny_id){
                $destiny->pivot->increment('stock', $request->amount);
                $pass = true;
            }
            if(!$pass){
            $product->destines()->attach($destiny_id, ['stock' => $request->amount]);
            }
        }

        session()->flash('success', 'Se ha guardado el detalle del egreso.');
        return redirect()->route('pharmacies.products.fractionation.show', $fractionationItem->fractionation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacy\FractionationItem  $fractionationItem
     * @return \Illuminate\Http\Response
     */
    public function show(FractionationItem $fractionationItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy\FractionationItem  $fractionationItem
     * @return \Illuminate\Http\Response
     */
    public function edit(FractionationItem $fractionationItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy\FractionationItem  $fractionationItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FractionationItem $fractionationItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy\FractionationItem  $fractionationItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(FractionationItem $fractionationItem)
    {
      $product = Product::find($fractionationItem->product_id);
      $product->stock = $product->stock + $fractionationItem->amount;
      $product->save();

      if($product->program_id == 46){ //APS ORTESIS
        $product->load('destines');
        $destiny_id = Fractionation::find($fractionationItem->fractionation_id)->destiny_id;
        $pass = false;
        foreach($product->destines as $destiny)
          if($destiny->id == $destiny_id){
              $destiny->pivot->decrement('stock', $fractionationItem->amount);
              $pass = true;
          }
        if(!$pass){
          $product->destines()->attach($destiny_id, ['stock' => -$fractionationItem->amount]);
        }
      }

      $fractionation = $fractionationItem->fractionation;
      $fractionationItem->delete();
      session()->flash('success', 'Se ha eliminado el ítem.');
      return redirect()->route('pharmacies.products.fractionation.show', $fractionation);
    }
}
