<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Destination;
use App\Models\Warehouse\Store;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function __construct()
    {
        $this->middleware('ensure.destination')->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.destinations.index', compact('store', 'nav'));
    }

    /**
     * Show the form for creating a new resource.
     * @param \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.destinations.create', compact('store', 'nav'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Destination  $destination
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Destination $destination, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.destinations.edit', compact('store', 'destination', 'nav'));
    }
}
