<?php

namespace App\Http\Controllers\Pharmacies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pharmacies\Product;
use App\Pharmacies\Category;
use App\Pharmacies\Program;
use App\Pharmacies\Unit;
use App\Pharmacies\Supplier;
use App\Pharmacies\Establishment;
use App\Pharmacies\Receiving;
use App\Pharmacies\Dispatch;
use App\Pharmacies\PurchaseItem;
use App\Pharmacies\Purchase;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name', 'ASC')->get();//->paginate(30);
        return view('pharmacies.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        $programs = Program::All();
        $units = Unit::All();
        return view('pharmacies.products.create', compact('categories','units','programs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // $this->validate($request, [
      //     'barcode' => 'unique:frm_products'
      // ]);

      $product = new Product($request->All());
      $product->stock = 0;
      $product->pharmacy_id = session('pharmacy_id');
      $product->save();

      session()->flash('info', 'El producto '.$product->name.' ha sido creado.');
      return redirect()->route('pharmacies.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::All();
        $programs = Program::All();
        return view('pharmacies.products.edit', compact('product','categories','programs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();

        session()->flash('info', 'El producto '.$product->name.' ha sido editado.');
        return redirect()->route('pharmacies.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
      //se elimina la cabecera y detalles
      $product->delete();
      session()->flash('success', 'El producto ha sido eliminado');
      return redirect()->route('pharmacies.products.index');
    }

    /**
     * Funciones Reportes
    **/

    public function repBincard(Request $request){
        $matrix = Product::SearchBincard($request->get('dateFrom'),
                                         $request->get('dateTo'),
                                         $request->get('product_id'));
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
        return view('pharmacies.reports.bincard', compact('matrix','request','products'));
    }

    public function repPurchases(Request $request){
      $fecha_inicio = $request->get('dateFrom');
      $fecha_termino = $request->get('dateTo');
      $supplier_id = $request->get('supplier_id');
      $invoice = $request->get('invoice');
      $acceptance_certificate = $request->get('acceptance_certificate');
      $program = $request->get('program');
      /*$purchaseItems= PurchaseItem::whereHas('purchase', function ($query) use ($supplier_id, $fecha_inicio,$fecha_termino,$invoice,$acceptance_certificate) {
                                                    $query->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                                          ->when($supplier_id, function ($q, $supplier_id) {
                                                               return $q->where('supplier_id', $supplier_id);
                                                            })
                                                          ->where('invoice', 'LIKE',"%$invoice%")
                                                          ->where('acceptance_certificate', 'LIKE',"%$acceptance_certificate%");
                                               })->paginate(15);*/
      $purchases = Purchase::where('pharmacy_id',session('pharmacy_id'))
                          ->whereBetween('date', [$fecha_inicio,$fecha_termino])
                          ->when($supplier_id, function ($q, $supplier_id) {
                               return $q->where('supplier_id', $supplier_id);
                            })
                          ->where('invoice', 'LIKE',"%$invoice%")
                          ->where('id', 'LIKE',"%$acceptance_certificate%")
                          ->whereHas('purchaseItems', function ($query) use ($program) {
                             return $query->whereHas('product', function ($query) use ($program) {
                                              return $query->whereHas('program', function ($query) use ($program) {
                                                               return $query->where('name','LIKE',"%$program%");
                                                             });
                                            });
                            })
                          ->orderBy('id','DESC')->paginate(15);

      $suppliers = Supplier::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
      return view('pharmacies.reports.purchase_report', compact('request','purchases','suppliers'));
    }

    public function repInformeMovimientos(Request $request){
      $tipo = $request->get('tipo'); // compras, ingresos o Egresos
      $fecha_inicio = $request->get('dateFrom');
      $fecha_termino = $request->get('dateTo');
      $supplier_id = $request->get('supplier_id');
      $establishment_id = $request->get('establishment_id');
      $notes = $request->get('notes');
      $program = $request->get('program');

      //compras
      $dataCollection = collect();
      if ($tipo == 1) {
        /*$dataCollection = PurchaseItem::whereHas('purchase', function ($query) use ($supplier_id, $fecha_inicio,$fecha_termino, $notes) {
                                                   $query->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                                         ->when($supplier_id, function ($q, $supplier_id) {
                                                              return $q->where('supplier_id', $supplier_id);
                                                           })
                                                         ->where('notes','LIKE',"%$notes%");
                                                 })->paginate(15);*/
       $dataCollection = Purchase::where('pharmacy_id',session('pharmacy_id'))
                                 ->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                 ->when($supplier_id, function ($q, $supplier_id) {
                                       return $q->where('supplier_id', $supplier_id);
                                  })
                                 ->where('notes','LIKE',"%$notes%")
                                 // ->paginate(15);
                                 ->get();
      }
      //ingresos
      if ($tipo == 2) {
        /*$dataCollection = ReceivingItem::whereHas('receiving', function ($query) use ($establishment_id, $fecha_inicio,$fecha_termino, $notes) {
                                                     $query->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                                           ->when($establishment_id, function ($q, $establishment_id) {
                                                                return $q->where('establishment_id', $establishment_id);
                                                             })
                                                           ->where('notes','LIKE',"%$notes%");
                                                   })->paginate(15);*/
       $dataCollection = Receiving::where('pharmacy_id',session('pharmacy_id'))
                                  ->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                  ->when($establishment_id, function ($q, $establishment_id) {
                                       return $q->where('establishment_id', $establishment_id);
                                    })
                                  ->where('notes','LIKE',"%$notes%")
                                  ->whereHas('receivingItems', function ($query) use ($program) {
                                      return $query->whereHas('product', function ($query) use ($program) {
                                                    return $query->whereHas('program', function ($query) use ($program) {
                                                                    return $query->where('name','LIKE',"%$program%");
                                                                  });
                                                  });
                                  })
                                  // ->paginate(15);
                                  ->get();
      }
      //egresos
      if ($tipo == 3) {
        /*$dataCollection = DispatchItem::whereHas('dispatch', function ($query) use ($establishment_id, $fecha_inicio,$fecha_termino, $notes) {
                                                     $query->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                                           ->when($establishment_id, function ($q, $establishment_id) {
                                                                return $q->where('establishment_id', $establishment_id);
                                                             })
                                                           ->where('notes','LIKE',"%$notes%");
                                                   })->paginate(15);*/
                                                   // dd($program);
       $dataCollection = Dispatch::where('pharmacy_id',session('pharmacy_id'))
                                ->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                ->when($establishment_id, function ($q, $establishment_id) {
                                     return $q->where('establishment_id', $establishment_id);
                                   })
                                ->where('notes','LIKE',"%$notes%")
                                ->whereHas('dispatchItems', function ($query) use ($program) {
                                    return $query->whereHas('product', function ($query) use ($program) {
                                                  return $query->whereHas('program', function ($query) use ($program) {
                                                                  return $query->where('name','LIKE',"%$program%");
                                                                });
                                                });
                                })
                                ->get();
                                // ->paginate(15);
                                // dd($dataCollection);
      }

      $suppliers = Supplier::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
      $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                     ->orderBy('name','ASC')->get();
      return view('pharmacies.reports.movimientos', compact('request','dataCollection','suppliers','establishments'));
    }

    public function repProductLastPrices(Request $request){
      $product_id = $request->product_id;
      $purchaseItems_aux= PurchaseItem::whereHas('purchase', function ($query) {
                                           return $query->where('pharmacy_id',session('pharmacy_id'));
                                        })->when($product_id, function ($q, $product_id) {
                                           return $q->where('product_id', $product_id);
                                        })->select(DB::raw('max(id) as id'))
                                          ->groupBy('product_id');
      $purchaseItems= PurchaseItem::whereHas('purchase', function ($query) {
                                     return $query->where('pharmacy_id',session('pharmacy_id'));
                                  })->whereIn('id', $purchaseItems_aux)->paginate(15);

      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.reports.product_last_prices', compact('request','products','purchaseItems'));
    }

    public function repConsumeHistory(Request $request){
      //dd($request->get('year'));
      $matrix = Product::SearchConsumosHistoricos($request->get('year'),
                                                  $request->get('category_id'),
                                                  $request->get('establishment_id'));

      $categories = Category::orderBy('name','ASC')->get();
      $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                     ->orderBy('name','ASC')->get();
      return view('pharmacies.reports.consume_history', compact('request','establishments','categories','matrix'));
    }

    public function repProduct(Request $request){
      //dd($request->get('year'));
      /*$matrix = Product::SearchConsumosHistoricos($request->get('year'),
                                                  $request->get('category_id'),
                                                  $request->get('establishment_id'));

      $categories = Category::orderBy('name','ASC')->get();
      $establishments = Establishment::orderBy('name','ASC')->get();
      */
      // dd($request);

      // FIX TIEMPO LIMITE DE EJECUCUCION Y MEMORIA LIMITE EN PHP.INI
      set_time_limit(3600);
      ini_set('memory_limit', '1024M');

      $matrix = Product::SearchProducts($request->get('product_id'), $request->get('program'));
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.reports.products', compact('request','products','matrix'));
    }
}
