<?php

namespace App\Http\Controllers\Pharmacies;

use App\Models\Documents\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Parameters\Parameter;
use App\Models\Pharmacies\Deliver;
use App\Models\Pharmacies\Destiny;
use App\Models\Pharmacies\Product;
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
        $destiny = null;
        $destines = null;
        $pending_deliveries_list = null;
        $pendings_by_product = null;
        if(auth()->user()->hasAnyPermission(['Pharmacy: transfer view ortesis', 'Pharmacy: transfer view IQQ', 'Pharmacy: transfer view AHO'])){
            $destines = Destiny::where('pharmacy_id',session('pharmacy_id'))
                                ->whereNotIn('id', [148, 128])
                                ->when(auth()->user()->can('Pharmacy: transfer view IQQ'), function($q) {
                                    $destinesSearch = Parameter::where('module', 'frm')->where('parameter', 'EstablishmentsIQQ')->first()->value;
                                    return $q->whereIn('id', explode(',', $destinesSearch));
                                })
                                ->when(auth()->user()->can('Pharmacy: transfer view AHO'), function($q) {
                                    $destinesSearch = Parameter::where('module', 'frm')->where('parameter', 'EstablishmentsAHO')->first()->value;
                                    return $q->whereIn('id', explode(',', $destinesSearch));
                                })
                                ->orderBy('name','ASC')->get();

            $filter = $request->get('filter') ?? $destines->pluck('id')->toArray();
            $filterDestiny = function($query) use ($filter) {
                $query->whereIn('id', (array) $filter);
            };

            $pending_deliveries = Deliver::with('destiny:id,name', 'product:id,name', 'document:id')
                                        ->when($filter, function ($q) use ($filterDestiny) {
                                            $q->whereHas('destiny', $filterDestiny);
                                        })
                                        ->where('remarks', 'PENDIENTE')
                                        ->orderBy('request_date','DESC')->paginate(15, ['*'], 'p1');

            $confirmed_deliveries = Deliver::with('destiny:id,name', 'product:id,name')
                                        ->when($filter, function ($q) use ($filterDestiny) {
                                            $q->whereHas('destiny', $filterDestiny);
                                        })
                                        ->where('remarks', 'NOT LIKE', 'PENDIENTE')
                                        ->orderBy('updated_at','DESC')->paginate(15, ['*'], 'p2');

            $products_by_destiny = Product::where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->whereNotIn('id', [1185, 1186, 1231])
                                            ->orderBy('name', 'ASC')->get();
        } else {

            if (auth()->user()->destines->count()==0) {
              session()->flash('warning', 'El usuario no tiene asignado destino. Contacte a secretaría de informática.');
              return redirect()->route('pharmacies.index');
            }

            $filter = auth()->user()->destines->first();
            $filterDestiny = function($query) use ($filter) {
                $query->where('destiny_id', $filter->id);
            };
            $products_by_destiny = Product::whereHas('destines', $filterDestiny)
                                            ->with(['destines' => $filterDestiny])
                                            ->where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->whereNotIn('id', [1185, 1186, 1231])
                                            ->orderBy('name', 'ASC')->paginate(15, ['*'], 'p3');

            $pending_deliveries = Deliver::with('destiny:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('destiny_id', $filter->id)
                                        ->orderBy('created_at','ASC')->paginate(15, ['*'], 'p1');

            $confirmed_deliveries = Deliver::with('destiny:id,name', 'product:id,name')
                                        ->where('remarks', 'NOT LIKE', 'PENDIENTE')
                                        ->where('destiny_id', $filter->id)
                                        ->orderBy('created_at','DESC')->paginate(15, ['*'], 'p2');

            $pending_deliveries_list = Deliver::with('destiny:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('destiny_id', $filter->id)->get();

            $pendings_by_product = $pending_deliveries_list->groupBy('product_id')->map(function($row){
                    return $row->sum('quantity');
            });
            $pendings_by_product->toArray();
        }

        return view('pharmacies.products.deliver.index', compact('pending_deliveries', 'confirmed_deliveries', 'products_by_destiny', 'destines', 'pendings_by_product', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if (auth()->user()->destines->count()==0) {
          session()->flash('warning', 'El usuario no tiene asignado destino. Contacte a secretaría de informática.');
          return redirect()->route('pharmacies.index');
        }

        if(auth()->user()->can('Pharmacy: transfer view ortesis')){
            session()->flash('warning', 'Ud. no tiene permiso para registrar y hacer entrega de ayuda técnica.');
            return redirect()->route('pharmacies.products.deliver.index');
        }

        $destiny_id = auth()->user()->destines->first()->id;
        $filterDestiny = function($query) use ($destiny_id) {
            $query->where('destiny_id', $destiny_id);
        };

        $products_by_destiny = Product::whereHas('destines', $filterDestiny)
                            ->with(['destines' => $filterDestiny])
                            ->where('pharmacy_id',session('pharmacy_id'))
                            ->where('program_id', 46) //APS ORTESIS
                            ->whereNotIn('id', [1185, 1186, 1231])
                            ->orderBy('name','ASC')->get();
        
        if($products_by_destiny->count() == 0){
            session()->flash('warning', 'Ud. no tiene permiso para registrar y hacer entrega de ayuda técnica porque el destino no presenta stock alguno de productos. Contacte con secretaría de informática.');
            return redirect()->route('pharmacies.products.deliver.index');
        }

        return view('pharmacies.products.deliver.create',compact('products_by_destiny'));
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
        $product = Product::with('destines')->find($deliver->product_id);
        $pass = false;
        foreach($product->destines as $destiny)
          if($destiny->id == $deliver->destiny_id){
              $destiny->pivot->decrement('stock', $deliver->quantity);
              $pass = true;
          }
        if(!$pass){
          $product->destines()->attach($deliver->destiny_id, ['stock' => -$deliver->quantity]);
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
        if(!auth()->user()->can('Pharmacy: transfer view ortesis')){
            session()->flash('warning', 'Ud. no tiene permiso para reestablecer ayudas técnicas al destino origen.');
            return redirect()->route('pharmacies.products.deliver.index');
        }

        $product = Product::with('destines')->find($deliver->product_id);
        $pass = false;
        foreach($product->destines as $destiny)
          if($destiny->id == $deliver->destiny_id){
              $destiny->pivot->increment('stock', $deliver->quantity);
              $pass = true;
          }
        if(!$pass){
          $product->destines()->attach($deliver->destiny_id, ['stock' => $deliver->quantity]);
        }

        $deliver->delete();
        session()->flash('success', 'Se ha reestablecido ayuda técnica al destino satisfactoriamente.');
        return redirect()->route('pharmacies.products.deliver.index');
    }
}
