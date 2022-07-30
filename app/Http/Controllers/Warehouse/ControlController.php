<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\Store;
use Illuminate\Http\Request;

class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Iluminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store, Request $request)
    {
        if($request->type == 'receiving' || $request->type == 'dispatch')
        {
            $type = $request->type;
            return view('warehouse.controls.index', compact('store', 'type'));
        }
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Iluminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store, Request $request)
    {
        if($request->type == 'receiving' || $request->type == 'dispatch')
        {
            $type = $request->type;
            return view('warehouse.controls.create', compact('store', 'type'));
        }
        return redirect()->route('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Control $control)
    {
        if($control->isReceiveFromStore() && !$control->isConfirmed())
            return view('warehouse.controls.review-product', compact('store', 'control'));
        else
            return view('warehouse.controls.edit', compact('store', 'control'));
    }

    /**s
     * Add product to Control
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Store $store, Control $control)
    {
        return view('warehouse.controls.add-product', compact('store', 'control'));
    }

    /**
     * Dispatch & Reception PDF report
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function pdf(Store $store, Control $control)
    {
        $type = '/';
        
        if($control->isReceiving())
            return view('warehouse.pdf.report-reception', compact('store', 'control', 'type'));
        else
            return view('warehouse.pdf.report-dispatch', compact('store', 'control', 'type'));
    }

    /**
     * Generate Reception
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function generateReception(Store $store)
    {
        return view('warehouse.stores.generate-reception', compact('store'));
    }
}
