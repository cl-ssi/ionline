<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Store;
use App\Models\Warehouse\StoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('warehouse.stores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('warehouse.stores.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        return view('warehouse.stores.edit', compact('store'));
    }

    /**
     * Manage store users.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function users(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.stores.manage-users', compact('store', 'nav'));
    }

    public function welcome()
    {
        return view('warehouse.stores.welcome');
    }

    public function activateStore(Store $store)
    {
        $storeActive = Auth::user()->active_store;

        if($storeActive)
        {
            $storeActive->pivot->status = 0;
            $storeActive->pivot->save();
        }

        $selectedActive = StoreUser::whereStoreId($store->id)->whereUserId(Auth::id())->first();
        if($selectedActive)
        {
            $selectedActive->update(['status' => 1]);
        }

        return redirect()->route('warehouse.store.welcome');
    }

    /**
     * Bincard Report
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.stores.report', compact('store', 'nav'));
    }
}
