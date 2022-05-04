<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Category;
use App\Models\Warehouse\Store;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('ensure.store');
        $this->middleware('ensure.category')->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store)
    {
        return view('warehouse.categories.index', compact('store'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store)
    {
        return view('warehouse.categories.create', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Category $category)
    {
        return view('warehouse.categories.edit', compact('store', 'category'));
    }
}
