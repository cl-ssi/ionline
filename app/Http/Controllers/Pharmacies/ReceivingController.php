<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\Receiving;
use App\Pharmacies\Establishment;
use App\Pharmacies\Product;
use Illuminate\Support\Facades\Auth;

class ReceivingController extends Controller
{
    /**
    * Instantiate a new controller instance.
    *
    * @return void
    */
    // public function __construct()
    // {
    //     $this->middleware('permission:Pharmacy: manager')->only('create');
    //     //$this->middleware('subscribed')->except('store');
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receivings = Receiving::where('pharmacy_id',session('pharmacy_id'))
                               ->orderBy('id','DESC')->paginate(200);
        return view('pharmacies.products.receiving.index', compact('receivings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                       ->orderBy('name','ASC')->get();
        return view('pharmacies.products.receiving.create',compact('establishments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $receiving = new Receiving($request->all());
        $receiving->pharmacy_id = session('pharmacy_id');
        $receiving->user_id = Auth::id();
        $receiving->save();

        session()->flash('success', 'Se ha guardado el encabezado del ingreso.');
        return redirect()->route('pharmacies.products.receiving.show', $receiving);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function show(Receiving $receiving)
    {
        $establishment = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                      ->find($receiving->establishment_id);
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
        return view('pharmacies.products.receiving.show',compact('establishment','receiving','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function edit(Receiving $receiving)
    {
      $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                     ->orderBy('name','ASC')->get();
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.receiving.edit', compact('establishments','receiving','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receiving $receiving)
    {
      $receiving->fill($request->all());
      $receiving->user_id = Auth::id();
      $receiving->save();
      //$computer->users()->sync($request->input('users'));
      session()->flash('success', 'El ingreso ha sido actualizado.');
      return redirect()->route('pharmacies.products.receiving.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receiving $receiving)
    {
        //se modifica el stock del producto
        $amount = 0;
        foreach ($receiving->receivingItems as $key => $receivingItem){
          $product = Product::find($receivingItem->product_id);
          $product->stock = $product->stock - $receivingItem->amount;
          $product->save();
        }

        //se elimina la cabecera y detalles
        $receiving->delete();
        session()->flash('success', 'El ingreso se ha sido eliminado');
        return redirect()->route('pharmacies.products.receiving.index');
    }

    public function record(Receiving $receiving)
    {
        return view('pharmacies.products.receiving.record', compact('receiving'));
    }
}
