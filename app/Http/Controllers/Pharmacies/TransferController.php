<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\Deliver;
use App\Pharmacies\Product;
use App\Pharmacies\Establishment;
use App\Pharmacies\Transfer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products_ortesis = null;
        $product_ortesis_list = null;
        $establishments = null;
        if(Auth::user()->can('Pharmacy: transfer view ortesis')){
            $products_ortesis = Product::whereHas('establishments', function($q) {
                $q->where('establishment_id', '!=', 148); //SS BODEGA IQUIQUE
            })
            ->with(['establishments' => function($q) {
                    $q->where('establishment_id', '!=', 148);
                }])
            ->where('pharmacy_id',session('pharmacy_id'))
            ->where('program_id', 46) //APS ORTESIS
            ->orderBy('name','ASC')->paginate(10, ['*'], 'p1');

            $product_ortesis_list = Product::where('pharmacy_id',session('pharmacy_id'))
                                    ->where('program_id', 46) //APS ORTESIS
                                    ->orderBy('name','ASC')->get();
            
            $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                            ->where('id', '!=', 148)
                                            ->orderBy('name','ASC')->get();

            $filter = $request->get('filter') != null ? $request->get('filter') : $establishments->first()->id;
            $filterEstablishment = function($query) use ($filter) {
                $query->where('establishment_id', $filter);
            };
            $products_by_establishment = Product::whereHas('establishments', $filterEstablishment)
                                            ->with(['establishments' => $filterEstablishment])
                                            ->where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->orderBy('name', 'ASC')->paginate(10, ['*'], 'p2');

            $transfers = Transfer::with('establishment_from:id,name', 'establishment_to:id,name', 'product:id,name', 'user:id,name,fathers_family')->orderBy('id','DESC')->paginate(10, ['*'], 'p3');
        } else {
            $filter = Auth::user()->establishments->first()->id;
            $filterEstablishment = function($query) use ($filter) {
                $query->where('establishment_id', $filter);
            };
            $products_by_establishment = Product::whereHas('establishments', $filterEstablishment)
                                            ->with(['establishments' => $filterEstablishment])
                                            ->where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->orderBy('name', 'ASC')->paginate(10, ['*'], 'p2');

            $transfers = Transfer::with('establishment_from:id,name', 'establishment_to:id,name', 'product:id,name', 'user:id,name,fathers_family')
                                 ->where('from', $filter)->orWhere('to', $filter)
                                 ->orderBy('id','DESC')->paginate(10, ['*'], 'p3');
        }

        $pending_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('establishment_id', $filter)->get();
        
        $pendings_by_product = $pending_deliveries->groupBy('product_id')->map(function($row){
                return $row->sum('quantity');
        });
        $pendings_by_product->toArray();

        return view('pharmacies.products.transfer.index', compact('products_ortesis', 'product_ortesis_list', 'establishments', 'products_by_establishment', 'transfers', 'filter', 'pendings_by_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $products_ortesis = Product::whereHas('establishments', function($q) {
                                            $q->where('establishment_id', '!=', 148); //SS BODEGA IQUIQUE
                                        })
                                    ->with(['establishments' => function($q) {
                                            $q->where('establishment_id', '!=', 148);
                                        }])
                                    ->where('pharmacy_id',session('pharmacy_id'))
                                    ->where('program_id', 46) //APS ORTESIS
                                    ->orderBy('name','ASC')->get();

        $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                       ->where('id', '!=', 148) //SS BODEGA IQUIQUE
                                       ->orderBy('name','ASC')->get();
                                        
        return view('pharmacies.products.transfer.create',compact('products_ortesis', 'establishments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $transfer = new Transfer;
        $transfer->product_id = $request->get('product_id');
        $transfer->quantity = $request->get('quantity');
        $transfer->from = $request->get('from');
        $transfer->to = $request->get('to');
        $transfer->user_id = Auth::id();
        $transfer->save();

        $product = Product::with('establishments')->find($request->get('product_id'));
        //from -> discount product actual establishment
        $pass = false;
        foreach($product->establishments as $establishment)
          if($establishment->id == $request->get('from')){
              $establishment->pivot->decrement('stock', $request->get('quantity'));
              $pass = true;
          }
        if(!$pass){
          $product->establishments()->attach($request->get('from'), ['stock' => -$request->get('quantity')]);
        }

        //to -> increment product actual establishment
        $pass = false;
        foreach($product->establishments as $establishment)
          if($establishment->id == $request->get('to')){
              $establishment->pivot->increment('stock', $request->get('quantity'));
              $pass = true;
          }
        if(!$pass){
          $product->establishments()->attach($request->get('to'), ['stock' => $request->get('quantity')]);
        }

        session()->flash('success', 'Se ha registrado el traslado satisfactoriamente.');
        return redirect()->route('pharmacies.products.transfer.index');
    }

    public function auth($establishment_id)
    {     
        $filterAATT = function($q){
            $q->where('pharmacy_id',session('pharmacy_id'))
              ->where('program_id', 46) //APS ORTESIS
              ->orderBy('name', 'ASC');
        };
        $establishment = Establishment::with(['products' => $filterAATT])->whereHas('products', $filterAATT)->find($establishment_id);
        
        $pending_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('establishment_id', $establishment_id)->get();
        
        $pendings_by_product = $pending_deliveries->groupBy('product_id')->map(function($row){
            return $row->sum('quantity');
        });
        $pendings_by_product->toArray();                                
        
        return view('pharmacies.products.transfer.auth', compact('establishment', 'pendings_by_product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($filter, Request $request)
    {
        if($request->has('filter')) return redirect()->route('pharmacies.products.transfer.edit', $request->get('filter'));
        // Editar stock de ayudas de tecnicas para cada establecimiento
        // $filterAATT = function($q){
        //     $q->where('pharmacy_id',session('pharmacy_id'))
        //       ->where('program_id', 46) //APS ORTESIS
        //       ->orderBy('name', 'ASC');
        // };

        // $establishment = Establishment::with(['products' => $filterAATT])
        //                                           ->whereHas('products', $filterAATT)
        //                                           ->find($filter);
        
        $establishment = Establishment::with('products')->find($filter);

        $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                       ->where('id', '!=', 148) //SS BODEGA IQUIQUE
                                       ->orderBy('name','ASC')->get();

        $products_ortesis = Product::where('pharmacy_id',session('pharmacy_id'))
                                    ->where('program_id', 46) //APS ORTESIS
                                    ->orderBy('name','ASC')->get();

        $stocks = collect();
        foreach($products_ortesis as $product){
            $stock = new Product;
            $stock->id = $product->id;
            $stock->name = $product->name;
                
            if($establishment->products->contains($product)){
                $stock->stock = $establishment->products->where('id', $product->id)->first()->pivot->stock;
                $stock->critic_stock = $establishment->products->where('id', $product->id)->first()->pivot->critic_stock;
            }
            $stocks->push($stock);
        }

        return view('pharmacies.products.transfer.edit', compact('filter', 'stocks', 'establishments', 'products_ortesis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $filter)
    {
        // guardar stock de ayudas de tecnicas para establecimiento $id
        $establishment = Establishment::find($filter);

        foreach($request->get('product_id') as $i => $product_id){
            $result = $establishment->products()->updateExistingPivot($product_id, [
                'stock' => $request->get('stock')[$i],
                'critic_stock' => $request->get('critic_stock')[$i],
            ]);
            if(!$result)
                $establishment->products()->attach($product_id, [
                    'stock' => $request->get('stock')[$i],
                    'critic_stock' => $request->get('critic_stock')[$i],
                ]);
        }
        return redirect()->route('pharmacies.products.transfer.index', compact('filter'))->with('success', 'Registro actualizado el stock satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
