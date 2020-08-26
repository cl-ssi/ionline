<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\Purchase;
use App\Pharmacies\Supplier;
use App\Pharmacies\Product;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $purchases = Purchase::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('id','DESC')->get();//paginate(15);
      foreach ($purchases as $key => $purchase) {
        $purchase->purchase_order_amount = "$".str_replace (",",".",number_format(round($purchase->purchase_order_amount * 1.19)));
      }
      // dd($purchases->where('id',389)->first()->purchase_order_amount);
      return view('pharmacies.products.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      $suppliers = Supplier::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
      return view('pharmacies.products.purchase.create',compact('suppliers'));
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
          //'invoice' => 'required|integer',
          //'despatch_guide' => 'required|numeric',
          //'invoice_amount' => 'numeric'
      ]);

      $purchase = new Purchase($request->all());
      $purchase->pharmacy_id = session('pharmacy_id');
      $purchase->doc_date = $purchase->invoice_date;
      $purchase->user_id = Auth::id();
      $purchase->save();

      session()->flash('success', 'Se ha guardado el encabezado de la compra.');
      return redirect()->route('pharmacies.products.purchase.show', $purchase);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacies\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
      $supplier = Supplier::find($purchase->supplier_id);
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.purchase.show',compact('supplier','purchase','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacies\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
      $suppliers = Supplier::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.purchase.edit', compact('suppliers','purchase','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacies\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
      $this->validate($request, [
          //'invoice' => 'required|integer',
          //'despatch_guide' => 'required|numeric',
          //'invoice_amount' => 'numeric'
      ]);

      $purchase->fill($request->all());
      $purchase->user_id = Auth::id();
      $purchase->save();
      //$computer->users()->sync($request->input('users'));
      session()->flash('success', 'La compra ha sido actualizado.');
      return redirect()->route('pharmacies.products.purchase.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacies\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
      //se modifica el stock del producto
      $amount = 0;
      foreach ($purchase->purchaseItems as $key => $purchaseItem){
        $product = Product::find($purchaseItem->product_id);
        $product->stock = $product->stock - $purchaseItem->amount;
        $product->save();
      }

      //se elimina la cabecera y detalles
      $purchase->delete();
      session()->flash('success', 'La compra se ha sido eliminado');
      return redirect()->route('pharmacies.products.purchase.index');
    }

    public function record(Purchase $purchase)
    {
        return view('pharmacies.products.purchase.record', compact('purchase'));
    }
}
