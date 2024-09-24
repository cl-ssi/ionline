<?php

namespace App\Http\Controllers\Pharmacies;

use App\Models\Documents\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents\Type;
use App\Models\Parameters\Parameter;
use App\Models\Pharmacies\Deliver;
use App\Models\Pharmacies\Product;
use App\Models\Pharmacies\Destiny;
use App\Models\Pharmacies\Transfer;
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
        $destines = null;
        $destiny = null;
        if(auth()->user()->hasAnyPermission(['Pharmacy: transfer view ortesis', 'Pharmacy: transfer view IQQ', 'Pharmacy: transfer view AHO'])){
            $products_ortesis = Product::whereHas('destines', function($q) {
                $q->whereNotIn('destiny_id', [148, 128]); //SS BODEGA IQUIQUE Y BORO/TORTUGA
            })
            ->with(['destines' => function($q) {
                $q->whereNotIn('destiny_id', [148, 128]);
            }])
            ->where('pharmacy_id',session('pharmacy_id'))
            ->where('program_id', 46) //APS ORTESIS
            ->whereNotIn('id', [1185, 1186, 1231])
            ->orderBy('name','ASC')->paginate(15, ['*'], 'p1');

            $product_ortesis_list = Product::where('pharmacy_id',session('pharmacy_id'))
                                    ->where('program_id', 46) //APS ORTESIS
                                    ->whereNotIn('id', [1185, 1186, 1231])
                                    ->orderBy('name','ASC')->get();
            
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

            // Se agrega porque hay casos en que no devuelve destinos
            if($destines->count()>0){
                $destiny = $destines->first()->id;
            }

            $filter = $request->get('filter') != null ? $request->get('filter') : $destiny;
            // return $filter;
            $filterDestiny = function($query) use ($filter) {
                $query->where('destiny_id', $filter);
            };
            $products_by_destiny = Product::whereHas('destines', $filterDestiny)
                                            ->with(['destines' => $filterDestiny])
                                            ->where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->whereNotIn('id', [1185, 1186, 1231])
                                            ->orderBy('name', 'ASC')->paginate(15, ['*'], 'p2');

            $transfers = Transfer::with('destiny_from:id,name', 'destiny_to:id,name', 'product:id,name', 'user:id,name,fathers_family')
                        ->when(auth()->user()->hasAnyPermission(['Pharmacy: transfer view IQQ', 'Pharmacy: transfer view AHO']), function($q) use ($filter) {
                            return $q->where('from', $filter)->orWhere('to', $filter);
                        })
                        ->orderBy('id','DESC')->paginate(15, ['*'], 'p3');
        } else {
            if (auth()->user()->destines->count()==0) {
                session()->flash('warning', 'El usuario no tiene asignado destino. Contacte a secretaría de informática.');
                return redirect()->route('pharmacies.index');
            }

            $filter = auth()->user()->destines->first()->id;
            $destiny = Destiny::find($filter);
            $filterDestiny = function($query) use ($filter) {
                $query->where('destiny_id', $filter);
            };
            $products_by_destiny = Product::whereHas('destines', $filterDestiny)
                                            ->with(['destines' => $filterDestiny])
                                            ->where('pharmacy_id',session('pharmacy_id'))
                                            ->where('program_id', 46) //APS ORTESIS
                                            ->whereNotIn('id', [1185, 1186, 1231])
                                            ->orderBy('name', 'ASC')->paginate(15, ['*'], 'p2');

            $transfers = Transfer::with('destiny_from:id,name', 'destiny_to:id,name', 'product:id,name', 'user:id,name,fathers_family')
                                 ->where('from', $filter)->orWhere('to', $filter)
                                 ->orderBy('id','DESC')->paginate(15, ['*'], 'p3');
        }

        $pending_deliveries = Deliver::with('destiny:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('destiny_id', $filter)->get();
        
        $pendings_by_product = $pending_deliveries->groupBy('product_id')->map(function($row){
                return $row->sum('quantity');
        });
        $pendings_by_product->toArray();

        return view('pharmacies.products.transfer.index', compact('products_ortesis', 'product_ortesis_list', 'destines', 'products_by_destiny', 'transfers', 'filter', 'pendings_by_product', 'destiny'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        // return $request;
        if($request->get('from') == $request->get('to')){
            session()->flash('warning', 'No es posible trasladar productos hacia un mismo destino.');
            return redirect()->back();
        }
        $transfer = new Transfer;
        $transfer->product_id = $request->get('product_id');
        $transfer->quantity = $request->get('quantity');
        $transfer->from = $request->get('from');
        $transfer->to = $request->get('to');
        $transfer->user_id = Auth::id();
        $transfer->save();

        $product = Product::with('destines')->find($request->get('product_id'));
        //from -> discount product actual destiny
        $pass = false;
        foreach($product->destines as $destiny)
          if($destiny->id == $request->get('from')){
              $destiny->pivot->decrement('stock', $request->get('quantity'));
              $pass = true;
          }
        if(!$pass){
          $product->destines()->attach($request->get('from'), ['stock' => -$request->get('quantity')]);
        }

        //to -> increment product actual destiny
        $pass = false;
        foreach($product->destines as $destiny)
          if($destiny->id == $request->get('to')){
              $destiny->pivot->increment('stock', $request->get('quantity'));
              $pass = true;
          }
        if(!$pass){
          $product->destines()->attach($request->get('to'), ['stock' => $request->get('quantity')]);
        }

        session()->flash('success', 'Se ha registrado el traslado satisfactoriamente.');
        return redirect()->route('pharmacies.products.transfer.index');
    }

    public function auth($destiny_id)
    {     
        if(!auth()->user()->can('Pharmacy: transfer view ortesis')){
            session()->flash('warning', 'Ud. no tiene permiso para autorizar la solicitud de stock via documento.');
            return redirect()->route('pharmacies.products.deliver.index');
        }

        $filterAATT = function($q){
            $q->where('pharmacy_id',session('pharmacy_id'))
              ->where('program_id', 46) //APS ORTESIS
              ->whereNotIn('product_id', [1185, 1186, 1231])
              ->orderBy('name', 'ASC');
        };
        $destiny = Destiny::with(['products' => $filterAATT])->whereHas('products', $filterAATT)->find($destiny_id);
        
        $pending_deliveries = Deliver::with('destiny:id,name', 'product:id,name')
                                        ->where('remarks', 'PENDIENTE')
                                        ->where('destiny_id', $destiny_id)
                                        ->doesntHave('document')->get();
        
        $pendings_by_product = $pending_deliveries->groupBy('product_id')->map(function($row){
            return $row->sum('quantity');
        });
        $pendings_by_product->toArray();

        $style = "border: 1px solid black; border-collapse: collapse; padding: 5px; font-family: Arial, Helvetica, sans-serif; font-size: 0.8rem;";
        
        $content = "<p style='font-family: Arial, Helvetica, sans-serif; font-size: 0.8rem;'>Mediante el presente documento y en marco a los problemas de <b>salud 36, piloto GES y decreto 22</b>, y a la evaluación de información de solicitud y entrega de ayudas técnicas ingresada por su destino en plataforma i.saludtarapaca.gob.cl, mediante el presente se informa a usted que las siguientes ayudas técnicas de encuentran disponible para ser retiradas en bodega del Servicio de Salud Tarapacá:</p>
        <p style='font-family: Arial, Helvetica, sans-serif; font-size: 0.8rem;'>Entrega para destino <b>{$destiny->name}</b></p>

        <table style='{$style}' align='center'>
            <thead>
            <tr style='{$style}'>
                <th style='{$style}' width='200'>Ayuda técnica</th>
                <th style='{$style}' width='150'>Según stock disponible en destino</th>
                <th style='{$style}' width='150'>Para stock crítico en destino</th>
                <th style='{$style}' width='150'>Para pendientes de entrega</th>
                <th style='{$style}' width='150'>Total a entregar</th>
            </tr>
            </thead>
            <tbody>";

        foreach($destiny->products as $product){
            $pendientes = isset($pendings_by_product[$product->id]) ? $pendings_by_product[$product->id] : 0;
            if($product->pivot->critic_stock + $pendientes > $product->pivot->stock){
                $for_critic = $product->pivot->critic_stock - $product->pivot->stock;
                $total_dlvr = $product->pivot->critic_stock + $pendientes - $product->pivot->stock;
                $content = $content . "<tr>
                                        <td style='{$style}'><b>{$product->name}</b></td>
                                        <td style='{$style}' align='center'>{$product->pivot->stock}</td>
                                        <td style='{$style}' align='center'>{$for_critic}</td>
                                        <td style='{$style}' align='center'>{$pendientes}</td>
                                        <td style='{$style}' align='center'><b>{$total_dlvr}</b></td>
                                    </tr>";
            }
        }

        $content = $content . "</tbody>
        </table>
        <ul style='font-family: Arial, Helvetica, sans-serif; font-size: 0.8rem;'>
            <li>Lugar de Retiro:  Obispo Labbe #962</li>
            <li>Horarios:  08:30 - 13:00 hrs. y 14:30 – 16:00 hrs. </li>
        </ul>";

        // return $content;
        
        // return view('pharmacies.products.transfer.auth', compact('destiny', 'pendings_by_product'));
        $document = new Document();
        $document->content = $content;
        $document->type_id = 2; /* TODO: Parametrizar (2=oficio)*/
        $document->for = 'SEGÚN DISTRIBUCIÓN';
        $document->responsible = 'Referente Técnico de Rehabilitación';
        $document->distribution = "APS.SSI@REDSALUD.GOV.CL\nOFICINA DE PARTES";

        $types = Type::whereNull('partes_exclusive')->pluck('name','id');
        return view('documents.create', compact('document', 'types'));
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
        if(!auth()->user()->can('Pharmacy: transfer view ortesis')){
            session()->flash('warning', 'Ud. no tiene permiso para modificar stock de productos por destino.');
            return redirect()->route('pharmacies.products.deliver.index');
        }

        if($request->has('filter')) return redirect()->route('pharmacies.products.transfer.edit', $request->get('filter'));
        // Editar stock de ayudas de tecnicas para cada establecimiento
        // $filterAATT = function($q){
        //     $q->where('pharmacy_id',session('pharmacy_id'))
        //       ->where('program_id', 46) //APS ORTESIS
        //       ->orderBy('name', 'ASC');
        // };

        // $destiny = Destiny::with(['products' => $filterAATT])
        //                                           ->whereHas('products', $filterAATT)
        //                                           ->find($filter);
        
        $destiny = Destiny::with('products')->find($filter);

        $destines = Destiny::where('pharmacy_id',session('pharmacy_id'))
                                       ->whereNotIn('id', [148, 128]) //SS BODEGA IQUIQUE
                                       ->orderBy('name','ASC')->get();

        $products_ortesis = Product::where('pharmacy_id',session('pharmacy_id'))
                                    ->where('program_id', 46) //APS ORTESIS
                                    ->whereNotIn('id', [1185, 1186, 1231])
                                    ->orderBy('name','ASC')->get();

        $stocks = collect();
        foreach($products_ortesis as $product){
            $stock = new Product;
            $stock->id = $product->id;
            $stock->name = $product->name;
                
            if($destiny->products->contains($product)){
                $stock->stock = $destiny->products->where('id', $product->id)->first()->pivot->stock;
                $stock->critic_stock = $destiny->products->where('id', $product->id)->first()->pivot->critic_stock;
            }
            $stocks->push($stock);
        }

        return view('pharmacies.products.transfer.edit', compact('filter', 'stocks', 'destines', 'products_ortesis'));
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
        $destiny = Destiny::find($filter);

        foreach($request->get('product_id') as $i => $product_id){
            $result = $destiny->products()->updateExistingPivot($product_id, [
                'stock' => $request->get('stock')[$i],
                'critic_stock' => $request->get('critic_stock')[$i],
            ]);
            if(!$result)
                $destiny->products()->attach($product_id, [
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
