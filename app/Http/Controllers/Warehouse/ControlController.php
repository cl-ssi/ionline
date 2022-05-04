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
     * @param \Iluminate\Http\Request  $request
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
     * @param \Iluminate\Http\Request  $request
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
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Control $control)
    {
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
        // TODO: Proteger ruta: Store->id = Control->store_id
        return view('warehouse.controls.add-product', compact('store', 'control'));
    }

    /**
     * Add product to Control
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function report(Store $store)
    {
        return view('warehouse.controls.report', compact('store'));
    }

    /**
     * Add product to Control
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function pdf(Store $store, Control $control)
    {
        return view('warehouse.pdf.report-dispatch', compact('store', 'control'));
    }
}
