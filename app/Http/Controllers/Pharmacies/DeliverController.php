<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\Deliver;
use App\Pharmacies\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $establishment = null;
        $pending_deliveries_list = null;
        $pendings_by_product = null;
        if(Auth::user()->can('Pharmacy: transfer view ortesis')){
            $pending_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->orderBy('updated_at','ASC')->paginate(10, ['*'], 'p1');

            $confirmed_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'NOT LIKE', 'PENDIENTE')
                                        ->orderBy('updated_at','DESC')->paginate(10, ['*'], 'p2');

            // $establishments = Establishment::with(['products' => function($q) {
            //                                                 $q->where('program_id', 46);
            //                                             }])
            //                                         ->whereHas('products', function($q) {
            //                                                 $q->where('program_id', 46); //APS ORTESIS
            //                                         })
            //                                         ->where('pharmacy_id',session('pharmacy_id'))
            //                                         ->where('id', '!=', 148) // SS BODEGA
            //                                         ->orderBy('name','ASC')->get();

            $products_by_establishment = Product::where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->orderBy('name', 'ASC')->get();
        } else {
            $establishment = Auth::user()->establishments->first();
            $filterEstablishment = function($query) use ($establishment) {
                $query->where('establishment_id', $establishment->id);
            };
            $products_by_establishment = Product::whereHas('establishments', $filterEstablishment)
                                            ->with(['establishments' => $filterEstablishment])
                                            ->where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->orderBy('name', 'ASC')->paginate(10, ['*'], 'p3');

            $pending_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('establishment_id', $establishment->id)
                                        ->orderBy('updated_at','ASC')->paginate(10, ['*'], 'p1');

            $confirmed_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'NOT LIKE', 'PENDIENTE')
                                        ->where('establishment_id', $establishment->id)
                                        ->orderBy('updated_at','DESC')->paginate(10, ['*'], 'p2');

            $pending_deliveries_list = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('establishment_id', $establishment->id)->get();
        
            $pendings_by_product = $pending_deliveries_list->groupBy('product_id')->map(function($row){
                    return $row->sum('quantity');
            });
            $pendings_by_product->toArray();
        }

        return view('pharmacies.products.deliver.index', compact('pending_deliveries', 'confirmed_deliveries', 'products_by_establishment', 'establishment', 'pendings_by_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $establishment_id = Auth::user()->establishments->first()->id;
        $filterEstablishment = function($query) use ($establishment_id) {
            $query->where('establishment_id', $establishment_id);
        };
        $products_by_establishment = Product::whereHas('establishments', $filterEstablishment)
                            ->with(['establishments' => $filterEstablishment])
                            ->where('pharmacy_id',session('pharmacy_id'))
                            ->where('program_id', 46) //APS ORTESIS
                            ->orderBy('name','ASC')->get();

        return view('pharmacies.products.deliver.create',compact('products_by_establishment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Deliver::create($request->all() + ['remarks' => 'PENDIENTE']);

        session()->flash('success', 'Se ha registrado la solicitud satisfactoriamente.');
        return redirect()->route('pharmacies.products.deliver.index');
    }

    public function confirm(Deliver $deliver)
    {
        $product = Product::with('establishments')->find($deliver->product_id);
        $pass = false;
        foreach($product->establishments as $establishment)
          if($establishment->id == $deliver->establishment_id){
              $establishment->pivot->decrement('stock', $deliver->quantity);
              $pass = true;
          }
        if(!$pass){
          $product->establishments()->attach($deliver->establishment_id, ['stock' => -$deliver->quantity]);
        }

        $deliver->remarks = "ENTREGADO " . Carbon::today()->format('d/m/Y');
        $deliver->save();

        session()->flash('success', 'Se ha confirmado la solicitud satisfactoriamente.');
        return redirect()->route('pharmacies.products.deliver.index');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
