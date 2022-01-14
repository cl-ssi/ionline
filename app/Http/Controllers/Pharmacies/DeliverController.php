<?php

namespace App\Http\Controllers\Pharmacies;

use App\Documents\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\Deliver;
use App\Pharmacies\Establishment;
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
    public function index(Request $request)
    {
        $establishment = null;
        $establishments = null;
        $pending_deliveries_list = null;
        $pendings_by_product = null;
        if(Auth::user()->can('Pharmacy: transfer view ortesis')){

            $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                            ->whereNotIn('id', [148, 128])
                                            ->orderBy('name','ASC')->get();

            $filter = $request->get('filter');
            $filterEstablishment = function($query) use ($filter) {
                $query->where('id', $filter);
            };

            $pending_deliveries = Deliver::with('establishment:id,name', 'product:id,name', 'document:id')
                                        ->when($filter, function ($q) use ($filterEstablishment) {
                                            $q->whereHas('establishment', $filterEstablishment);
                                        })
                                        ->where('remarks', 'PENDIENTE')
                                        ->orderBy('request_date','DESC')->paginate(15, ['*'], 'p1');

            $confirmed_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->when($filter, function ($q) use ($filterEstablishment) {
                                            $q->whereHas('establishment', $filterEstablishment);
                                        })
                                        ->where('remarks', 'NOT LIKE', 'PENDIENTE')
                                        ->orderBy('updated_at','DESC')->paginate(15, ['*'], 'p2');

            $products_by_establishment = Product::where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->whereNotIn('id', [1185, 1186, 1231])
                                            ->orderBy('name', 'ASC')->get();
        } else {

            if (Auth::user()->establishments->count()==0) {
              session()->flash('warning', 'El usuario no tiene asignado establecimiento. Contacte a secretaría de informática.');
              return redirect()->route('pharmacies.index');
            }

            $filter = Auth::user()->establishments->first();
            $filterEstablishment = function($query) use ($filter) {
                $query->where('establishment_id', $filter->id);
            };
            $products_by_establishment = Product::whereHas('establishments', $filterEstablishment)
                                            ->with(['establishments' => $filterEstablishment])
                                            ->where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->whereNotIn('id', [1185, 1186, 1231])
                                            ->orderBy('name', 'ASC')->paginate(15, ['*'], 'p3');

            $pending_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('establishment_id', $filter->id)
                                        ->orderBy('created_at','ASC')->paginate(15, ['*'], 'p1');

            $confirmed_deliveries = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'NOT LIKE', 'PENDIENTE')
                                        ->where('establishment_id', $filter->id)
                                        ->orderBy('created_at','DESC')->paginate(15, ['*'], 'p2');

            $pending_deliveries_list = Deliver::with('establishment:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('establishment_id', $filter->id)->get();

            $pendings_by_product = $pending_deliveries_list->groupBy('product_id')->map(function($row){
                    return $row->sum('quantity');
            });
            $pendings_by_product->toArray();
        }

        return view('pharmacies.products.deliver.index', compact('pending_deliveries', 'confirmed_deliveries', 'products_by_establishment', 'establishments', 'pendings_by_product', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if (Auth::user()->establishments->count()==0) {
          session()->flash('warning', 'El usuario no tiene asignado establecimiento. Contacte a secretaría de informática.');
          return redirect()->route('pharmacies.index');
        }

        $establishment_id = Auth::user()->establishments->first()->id;
        $filterEstablishment = function($query) use ($establishment_id) {
            $query->where('establishment_id', $establishment_id);
        };
        $products_by_establishment = Product::whereHas('establishments', $filterEstablishment)
                            ->with(['establishments' => $filterEstablishment])
                            ->where('pharmacy_id',session('pharmacy_id'))
                            ->where('program_id', 46) //APS ORTESIS
                            ->whereNotIn('id', [1185, 1186, 1231])
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

    public function saveDocId(Deliver $deliver, Request $request)
    {
        $doc = Document::find($request->get('document_id'));
        if($doc == null) return redirect()->route('pharmacies.products.deliver.index')->with(['danger' => 'N° interno no existe, vuelva a intentarlo.']);
        $deliver->document_id = $request->get('document_id');
        $deliver->save();
        session()->flash('success', 'Se ha guardado N° interno satisfactoriamente.');
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
    public function destroy(Deliver $deliver)
    {
        $deliver->delete();
        session()->flash('success', 'Se ha borrado registro de entrega pendiente satisfactoriamente.');
        return redirect()->route('pharmacies.products.deliver.index');
    }

    public function restore(Deliver $deliver)
    {
        $product = Product::with('establishments')->find($deliver->product_id);
        $pass = false;
        foreach($product->establishments as $establishment)
          if($establishment->id == $deliver->establishment_id){
              $establishment->pivot->increment('stock', $deliver->quantity);
              $pass = true;
          }
        if(!$pass){
          $product->establishments()->attach($deliver->establishment_id, ['stock' => $deliver->quantity]);
        }

        $deliver->delete();
        session()->flash('success', 'Se ha reestablecido ayuda técnica al establecimiento satisfactoriamente.');
        return redirect()->route('pharmacies.products.deliver.index');
    }
}
