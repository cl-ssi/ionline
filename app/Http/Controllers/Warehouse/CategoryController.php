<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Category;
use App\Models\Warehouse\Store;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('ensure.category')->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.categories.index', compact('store', 'nav'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.categories.create', compact('store', 'nav'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Category  $category
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Category $category, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.categories.edit', compact('store', 'category', 'nav'));
    }
}
