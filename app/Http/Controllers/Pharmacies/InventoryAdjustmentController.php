<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Receiving;
use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\Dispatch;
use App\Models\Pharmacies\DispatchItem;
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
        $product = Product::find($request->product_id);
        $batch = Batch::find($request->due_date_batch);

        if($inventoryAdjustment->user_id != auth()->user()->id){
            session()->flash('warning', 'Solo podrá modificar este ajuste de inventario la persona que lo creó.');
            return redirect()->back();
        }

        if($dispatch && $dispatch->dispatchItems->where('product_id',$product->id)->count()){
            session()->flash('warning', 'Ya ingresó un valor para ese producto, intentelo nuevamente.');
            return redirect()->back();
        }

        if($receiving && $receiving->receivingItems->where('product_id',$product->id)->count()){
            session()->flash('warning', 'Ya ingresó un valor para ese producto, intentelo nuevamente.');
            return redirect()->back();
        }

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
            // si no tiene creada una cabecera de egresos, se crea una nueva
            if(!$dispatch){
                $dispatch = new Dispatch();
                $dispatch->date = $inventoryAdjustment->date;
                $dispatch->pharmacy_id = $inventoryAdjustment->pharmacy_id;
                $dispatch->notes = "AJUSTE DE INVENTARIO" . ($inventoryAdjustment->notes ? ' - ' . $inventoryAdjustment->notes : '');
                $dispatch->inventory_adjustment_id = $inventoryAdjustment->id;
                $dispatch->user_id = $inventoryAdjustment->user_id;
                $dispatch->save();
            }

            $dispatchItem = new DispatchItem();
            $dispatchItem->barcode = $product->barcode;
            $dispatchItem->dispatch_id = $dispatch->id;
            $dispatchItem->product_id = $request->product_id;
            $dispatchItem->amount = ($request->count - $request->amount);
            $dispatchItem->unity = $product->unit;
            $dispatchItem->due_date = $batch->due_date;
            $dispatchItem->batch = $batch->batch;
            $dispatchItem->batch_id = $batch->id;
            $dispatchItem->save();

            session()->flash('success', 'Se ha registrado el movimiento.');
            return redirect()->back();
        }

    }

    public function edit(InventoryAdjustment $inventoryAdjustment){
        return view('pharmacies.products.inventoryAdjustment.edit', compact('inventoryAdjustment'));
    }

    public function destroy(InventoryAdjustment $inventoryAdjustment){
        $receiving = $inventoryAdjustment->receiving;
        $dispatch = $inventoryAdjustment->dispatch;

        if($receiving && $receiving->receivingItems->count()>0){
            session()->flash('warning', 'No se puede eliminar un ajuste de inventario con movimientos dentro.');
            return redirect()->back();
        }
        if($dispatch && $dispatch->dispatchItems->count()>0){
            session()->flash('warning', 'No se puede eliminar un ajuste de inventario con movimientos dentro.');
            return redirect()->back();
        }

        if($inventoryAdjustment->user_id != auth()->user()->id){
            session()->flash('warning', 'Solo podrá modificar este ajuste de inventario la persona que lo creó.');
            return redirect()->back();
        }

        if($receiving){
            $receiving->delete();
        }
        if($dispatch){
            $dispatch->delete();
        }

        $inventoryAdjustment->delete();

        session()->flash('success', 'Se ha eliminado el ajuste de inventario.');
        return redirect()->back();
    }

    public function destroy_receivingItem(ReceivingItem $receivingItem)
    {
        $product = Product::find($receivingItem->product_id);
        if($product){
            $product->stock = $product->stock - $receivingItem->amount;
            $product->save();

            $receiving = $receivingItem->receiving;
            $receivingItem->delete();

            session()->flash('success', 'Se ha eliminado el ítem.');
            return redirect()->back();
        }else{
            session()->flash('warning', 'No se ha encontrado el producto que se intenta eliminar.');
            return redirect()->back();
        }
    }

    public function destroy_dispatchItem(DispatchItem $dispatchItem)
    {
        $product = Product::find($dispatchItem->product_id);
        if($product){
            $product->stock = $product->stock - $dispatchItem->amount;
            $product->save();

            $receiving = $dispatchItem->receiving;
            $dispatchItem->delete();

            session()->flash('success', 'Se ha eliminado el ítem.');
            return redirect()->back();
        }else{
            session()->flash('warning', 'No se ha encontrado el producto que se intenta eliminar.');
            return redirect()->back();
        }
    }
}
