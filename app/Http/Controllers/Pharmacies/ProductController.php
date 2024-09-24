<?php

namespace App\Http\Controllers\Pharmacies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharmacies\Product;
use App\Models\Pharmacies\Category;
use App\Models\Pharmacies\Program;
use App\Models\Pharmacies\Unit;
use App\Models\Pharmacies\Supplier;
use App\Models\Pharmacies\Destiny;
use App\Models\Pharmacies\Receiving;
use App\Models\Pharmacies\Dispatch;
use App\Models\Pharmacies\PurchaseItem;
use App\Models\Pharmacies\Purchase;
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
                            ->with('category','program')
                            ->orderBy('name', 'ASC')
                            ->get();//->paginate(30);
        return view('pharmacies.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $programs = Program::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
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
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
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
     * @param  \App\Models\Pharmacies\Product  $product
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
     * @param  \App\Models\Pharmacies\Product  $product
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
      $destiny_id = $request->get('destiny_id');
      $notes = $request->get('notes');
      $program = $request->get('program');
      $product = $request->get('product');

      //compras
      $dataCollection = collect();
      if ($tipo == 1) {
       $dataCollection = Purchase::where('pharmacy_id',session('pharmacy_id'))
                                    ->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                    ->when($supplier_id, function ($q, $supplier_id) {
                                        return $q->where('supplier_id', $supplier_id);
                                    })
                                    ->where('notes','LIKE',"%$notes%")
                                    ->when($product, function ($q, $product) {
                                        return $q->whereHas('purchaseItems', function ($query) use ($product) {
                                                        return $query->whereHas('product', function ($query) use ($product) {
                                                                        return $query->where('name','LIKE',"%$product%");
                                                                    });
                                                    });
                                    })
                                    ->whereHas('purchaseItems', function ($query) use ($program) {
                                        return $query->whereHas('product', function ($query) use ($program) {
                                                      return $query->whereHas('program', function ($query) use ($program) {
                                                                      return $query->where('name','LIKE',"%$program%");
                                                                    });
                                                    });
                                    })
                                    ->with('supplier')
                                    ->get();
      }
      //ingresos
      if ($tipo == 2) {
       $dataCollection = Receiving::where('pharmacy_id',session('pharmacy_id'))
                                ->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                ->when($destiny_id, function ($q, $destiny_id) {
                                    return $q->where('destiny_id', $destiny_id);
                                })
                                ->where('notes','LIKE',"%$notes%")
                                ->when($product, function ($q, $product) {
                                return $q->whereHas('receivingItems', function ($query) use ($product) {
                                                return $query->whereHas('product', function ($query) use ($product) {
                                                                return $query->where('name','LIKE',"%$product%");
                                                            });
                                            });
                                })
                                ->whereHas('receivingItems', function ($query) use ($program) {
                                    return $query->whereHas('product', function ($query) use ($program) {
                                                return $query->whereHas('program', function ($query) use ($program) {
                                                                return $query->where('name','LIKE',"%$program%");
                                                                });
                                                });
                                })
                                ->with('destiny')
                                ->get();
      }
      //egresos
      if ($tipo == 3) {
       $dataCollection = Dispatch::where('pharmacy_id',session('pharmacy_id'))
                                ->whereBetween('date', [$fecha_inicio,$fecha_termino])
                                ->when($destiny_id, function ($q, $destiny_id) {
                                     return $q->where('destiny_id', $destiny_id);
                                   })
                                ->where('notes','LIKE',"%$notes%")
                                ->when($product, function ($q, $product) {
                                    return $q->whereHas('dispatchItems', function ($query) use ($product) {
                                                    return $query->whereHas('product', function ($query) use ($product) {
                                                                    return $query->where('name','LIKE',"%$product%");
                                                                });
                                                });
                                })
                                ->whereHas('dispatchItems', function ($query) use ($program) {
                                    return $query->whereHas('product', function ($query) use ($program) {
                                                  return $query->whereHas('program', function ($query) use ($program) {
                                                                  return $query->where('name','LIKE',"%$program%");
                                                                });
                                                });
                                })
                                ->with('destiny')
                                ->get();
      }

      $suppliers = Supplier::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
      $destines = Destiny::where('pharmacy_id',session('pharmacy_id'))
                                     ->orderBy('name','ASC')->get();
      return view('pharmacies.reports.movimientos', compact('request','dataCollection','suppliers','destines'));
    }

    public function repProductLastPrices(Request $request){
      $product_id = $request->product_id;
      $purchaseItems_aux= PurchaseItem::whereHas('purchase', function ($query) {
                                           return $query->where('pharmacy_id',session('pharmacy_id'));
                                        })->when($product_id, function ($q, $product_id) {
                                           return $q->where('product_id', $product_id);
                                        })->select(DB::raw('max(id) as id'))
                                          ->groupBy('product_id')->get();
                                        //   dd($purchaseItems_aux);
      $purchaseItems= PurchaseItem::whereHas('purchase', function ($query) {
                                     return $query->where('pharmacy_id',session('pharmacy_id'));
                                  })->whereIn('id', $purchaseItems_aux)->paginate(15);

      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.reports.product_last_prices', compact('request','products','purchaseItems'));
    }

    public function repConsumeHistory(Request $request){
        $matrix = Product::SearchConsumosHistoricos($request->get('year'),
                                                    $request->get('category_id'),
                                                    $request->get('program_id'),
                                                    $request->get('destiny_id'));

        $categories = Category::orderBy('name','ASC')->get();
        $destines = Destiny::where('pharmacy_id',session('pharmacy_id'))
                                     ->orderBy('name','ASC')->get();
        $programs = Program::orderBy('name','ASC')->get();
      return view('pharmacies.reports.consume_history', compact('request','destines','categories','matrix','programs'));
    }

    public function repProductByBatch(Request $request){
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
                            ->orderBy('name','ASC')
                            ->get();

        $product_id = $request->product_id;
        $status = $request->status;

        $products_data = Product::where('pharmacy_id',session('pharmacy_id'))
                            ->when($product_id, function ($q, $product_id) {
                                return $q->where('id', $product_id);
                            })

                            ->when($status == 0, function ($q) {
                                return $q->whereHas('batchs', function ($query) {
                                            return $query->where('due_date','>=',now())
                                                        ->where('count','>',0);
                                        })->with([
                                            'batchs' => function ($query)  {
                                                $query->where('due_date','>=',now())
                                                    ->where('count','>',0);
                                        }]);
                            })
                            ->when($status == 1, function ($q) {
                                return $q->whereHas('batchs', function ($query) {
                                            return $query->where('due_date','<',now())
                                                        ->where('count','>',0);
                                        })->with([
                                            'batchs' => function ($query)  {
                                                $query->where('due_date','<',now())
                                                    ->where('count','>',0);
                                        }]);
                            })

                            ->when($status == 2, function ($q) {
                                return $q->whereHas('batchs', function ($query) {
                                            return $query->where('due_date','>=',now())
                                                        ->where('count','<=',0);
                                        })->with([
                                            'batchs' => function ($query)  {
                                                $query->where('due_date','>=',now())
                                                    ->where('count','<=',0);
                                        }]);
                            })
                            ->when($status == 3, function ($q) {
                                return $q->whereHas('batchs', function ($query) {
                                            return $query->where('due_date','<',now())
                                                        ->where('count','<=',0);
                                        })->with([
                                            'batchs' => function ($query)  {
                                                $query->where('due_date','<',now())
                                                    ->where('count','<=',0);
                                        }]);
                            })
                            
                            ->with('program','receivingItems')
                            ->orderBy('name','ASC')
                            ->get();

        return view('pharmacies.reports.products_by_batch', compact('request','products','products_data'));
    }

    public function repProduct(Request $request){
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
                            ->orderBy('name','ASC')
                            ->get();

        $product_id = $request->product_id;

        $products_data = Product::where('pharmacy_id',session('pharmacy_id'))
                            ->when($product_id, function ($q, $product_id) {
                                return $q->where('id', $product_id);
                            })
                            ->with('program','receivingItems')
                            ->orderBy('name','ASC')
                            ->get();

        return view('pharmacies.reports.products', compact('request','products','products_data'));
    }
}
