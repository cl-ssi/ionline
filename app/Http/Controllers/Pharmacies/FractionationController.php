<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\Fractionation;
use App\Models\Pharmacies\FractionationItem;
use App\Models\Establishment;
use App\Models\Pharmacies\File;
use App\Models\Pharmacies\Product;

use Illuminate\Support\Facades\Storage;
use App\Exports\FractionationExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class FractionationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $fractionations = Fractionation::where('pharmacy_id',session('pharmacy_id'))
                            ->with('originEstablishment')
                            ->orderBy('id','DESC')
                            ->paginate(200);

      return view('pharmacies.products.fractionation.index', compact('fractionations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $establishments = Establishment::orderBy('name','ASC')->get();
        return view('pharmacies.products.fractionation.create',compact('establishments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $fractionation = new Fractionation($request->all());
      $fractionation->pharmacy_id = session('pharmacy_id');
      $fractionation->save();

      session()->flash('success', 'Se ha guardado el encabezado del fraccionamiento.');
      return redirect()->route('pharmacies.products.fractionation.show', $fractionation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacy\Fractionation  $fractionation
     * @return \Illuminate\Http\Response
     */
    public function show(Fractionation $fractionation)
    { 
      $establishment = Establishment::find($fractionation->origin_establishment_id);
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.fractionation.show', compact('establishment','fractionation','products'));
    }

    public function getFromProduct_due_date($product_id){
      $products = Product::where('id',$product_id)->get();
      $matrix_due_date = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          $matrix_due_date[$cont] = $receivingItems->due_date;
          $cont = $cont + 1;
        }
      }

      $matrix_due_date=array_unique($matrix_due_date);
      //$matrix_batch=array_unique($matrix_batch);

      return $matrix_due_date;
    }

    public function getFromProduct_batch($product_id, $due_date){
      $products = Product::where('id',$product_id)
                         ->get();
      $matrix_batch = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          if($receivingItems->due_date == $due_date){
            $matrix_batch[$cont] = $receivingItems->batch;
            $cont = $cont + 1;
          }
        }
      }
      //$matrix_due_date=array_unique($matrix_due_date);
      $matrix_batch=array_unique($matrix_batch);

      return $matrix_batch;
    }

    public function getFromProduct_count($product_id, $due_date, $batch){
      $batch = str_replace("*", "/", $batch);
      $products = Product::where('id',$product_id)->get();
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          if($receivingItems->due_date == $due_date && $receivingItems->batch == $batch){
            $cont = $cont + $receivingItems->amount;
          }
        }
        foreach ($product->fractionationItems as $key1 => $fractionationItem) {
          if($fractionationItem->due_date == $due_date && $fractionationItem->batch == $batch){
            $cont = $cont - $fractionationItem->amount;
          }
        }
      }

      return $cont;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy\Fractionation  $fractionation
     * @return \Illuminate\Http\Response
     */
    public function edit(Fractionation $fractionation)
    {
		//obtiene fechas de vencimiento y lotes de todos los ingresos y compras de todos los productos.
		$products = Product::with(['receivingItems'])
			->where('pharmacy_id',session('pharmacy_id'))
			->orderBy('name', 'ASC')->get();

      $matrix_due_date = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          $matrix_due_date[$cont] = $receivingItems->due_date;
          $cont = $cont + 1;
        }
      }
      $matrix_batch = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          $matrix_batch[$cont] = $receivingItems->batch;
          $cont = $cont + 1;
        }
      }
      if ($matrix_due_date!=null) {
        $matrix_due_date=array_unique($matrix_due_date);
      }
      if ($matrix_batch!=null) {
        $matrix_batch=array_unique($matrix_batch);
      }

      $establishments = Establishment::orderBy('name','ASC')->get();
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.fractionation.edit', compact('establishments','fractionation','products','matrix_due_date','matrix_batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy\Fractionation  $fractionation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fractionation $fractionation)
    {
        $fractionation->fill($request->all());
        $fractionation->save();

      session()->flash('success', 'El fraccionamiento ha sido actualizado.');
      return redirect()->route('pharmacies.products.fractionation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy\Fractionation  $fractionation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fractionation $fractionation)
    {
      //se modifica el stock del producto
      $amount = 0;
      foreach ($fractionation->items as $key => $item){
        $product = Product::find($item->product_id);
        $product->stock = $product->stock + $item->amount;
        $product->save();

        if($product->program_id == 46){ //APS ORTESIS
          $product->load('destines');
          $destiny_id = Fractionation::find($item->fractionation_id)->destiny_id;
          $pass = false;
          foreach($product->destines as $destiny)
            if($destiny->id == $destiny_id){
                $destiny->pivot->decrement('stock', $item->amount);
                $pass = true;
            }
          if(!$pass){
            $product->destines()->attach($destiny_id, ['stock' => - $item->amount]);
          }
        }

        $item->delete();
      }

      //se elimina la cabecera y detalles
      $fractionation->delete();
      session()->flash('success', 'La entrega se ha sido eliminado');
      return redirect()->route('pharmacies.products.fractionation.index');
    }

    public function record(Fractionation $fractionation)
    {
        return view('pharmacies.products.fractionation.record', compact('fractionation'));
    }

    public function exportExcel(){
        return Excel::download(new FractionationExport, 'entregas.xlsx');
    }
}
