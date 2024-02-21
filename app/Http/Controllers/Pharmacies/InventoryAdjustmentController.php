<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Receiving;
use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\InventoryAdjustmentType;
use App\Models\Pharmacies\InventoryAdjustment;
use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\Product;

class InventoryAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventoryAdjustments = InventoryAdjustment::where('pharmacy_id',session('pharmacy_id'))->paginate(50);
        return view('pharmacies.products.inventoryAdjustment.index',compact('inventoryAdjustments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventoryAdjustmentTypes = InventoryAdjustmentType::all();
        return view('pharmacies.products.inventoryAdjustment.create',compact('inventoryAdjustmentTypes'));
    }

    public function store(Request $request)
    {
        $inventoryAdjustment = new InventoryAdjustment($request->all());
        $inventoryAdjustment->pharmacy_id = session('pharmacy_id');
        $inventoryAdjustment->user_id = auth()->user()->id;
        $inventoryAdjustment->save();

        session()->flash('success', 'Se ha guardado el encabezado del ajuste de inventario.');
        return redirect()->route('pharmacies.products.inventory_adjustments.show', $inventoryAdjustment);

        
    }

    public function show(InventoryAdjustment $inventoryAdjustment){
        return view('pharmacies.products.inventoryAdjustment.show', compact('inventoryAdjustment'));
    }

    public function store_detail(Request $request){
        // dd($request);
        $inventoryAdjustment = InventoryAdjustment::find($request->inventoryAdjustment_id);
        $receiving = $inventoryAdjustment->receiving;
        $dispatch = $inventoryAdjustment->dispatch;
        // si es mayor a lo que existe, se hace un ingreso
        if($request->amount > $request->count){
            // si no tiene creada una cabecera de ingresos, se crea una nueva
            if(!$receiving){
                $receiving = new Receiving();
                $receiving->date = $inventoryAdjustment->date;
                $receiving->pharmacy_id = $inventoryAdjustment->pharmacy_id;
                $receiving->notes = "AJUSTE DE INVENTARIO" . ($inventoryAdjustment->notes ? ' - ' . $inventoryAdjustment->notes : '');
                $receiving->inventory_adjustment_id = $inventoryAdjustment->id;
                $receiving->user_id = $inventoryAdjustment->user_id;
                $receiving->save();
            }

            // id', 'barcode', 'receiving_id', 'product_id', 'amount', 'unity', 'due_date','batch','batch_id','created_at'
            $product = Product::find($request->product_id);
            $batch = Batch::find($request->due_date_batch);

            $receivingItem = new ReceivingItem();
            $receivingItem->barcode = $product->barcode;
            $receivingItem->receiving_id = $receiving->id;
            $receivingItem->product_id = $request->product_id;
            $receivingItem->amount = ($request->amount - $request->count);
            $receivingItem->unity = $product->unit;
            $receivingItem->due_date = $batch->due_date;
            $receivingItem->batch = $batch->batch;
            $receivingItem->batch_id = $batch->id;
            $receivingItem->save();

            session()->flash('success', 'Se ha registrado el movimiento.');
            return redirect()->back();
        }
        // si es menor, se hace un egreso
        elseif($request->amount < $request->count){

        }

    }

    public function edit(InventoryAdjustment $inventoryAdjustment){
        // dd($inventoryAdjustment);
        return view('pharmacies.products.dispatch.edit', compact('establishments','dispatch','products','matrix_due_date','matrix_batch'));
    }

    public function destroy(InventoryAdjustment $inventoryAdjustment){
        // dd($inventoryAdjustment);
    }
}
