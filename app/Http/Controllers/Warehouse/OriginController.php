<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Origin;
use App\Models\Warehouse\Store;

class OriginController extends Controller
{
    public function __construct()
    {
        $this->middleware('ensure.origin')->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store)
    {
        return view('warehouse.origins.index', compact('store'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store)
    {
        return view('warehouse.origins.create', compact('store'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @param \App\Models\Warehouse\Origin  $origin
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Origin $origin)
    {
        return view('warehouse.origins.edit', compact('store', 'origin'));
    }
}
