<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\Store;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('ensure.product')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store)
    {
        return view('warehouse.products.index', compact('store'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store)
    {
        return view('warehouse.products.create', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Warehouse\Store  $store
     * @param \App\Models\Warehouse\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Product $product)
    {
        return view('warehouse.products.edit', compact('store', 'product'));
    }
}
