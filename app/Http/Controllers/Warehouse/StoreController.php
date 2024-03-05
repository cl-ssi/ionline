<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Store;
use App\Models\Warehouse\StoreUser;
use App\Models\Finance\Dte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $id = $request->input('id');
        $folio = $request->input('folio');
        $oc = $request->input('oc');
        $folio_compromiso = $request->input('folio_compromiso');
        $folio_devengo = $request->input('folio_devengo');

        $query = Dte::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($folio) {
            $query->where('folio', $folio);
        }

        if ($oc) {
            $query->where('folio_oc', $oc);
        }

        if ($folio_compromiso) {
            $query->where('folio_compromiso_sigfe', $folio_compromiso);
        }

        if ($folio_devengo) {
            $query->where('folio_devengo_sigfe', $folio_devengo);
        }

        return $query;
    }

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

    /**
     * @return \Illuminate\Contracts\Support\Arrayable
     */
    public function welcome()
    {
        return view('warehouse.stores.welcome');
    }

    /**
     * @param  Store $store
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateStore(Store $store)
    {
        $storeActive = auth()->user()->active_store;

        if ($storeActive) {
            $storeActive->pivot->status = 0;
            $storeActive->pivot->save();
        }

        $selectedActive = StoreUser::whereStoreId($store->id)->whereUserId(Auth::id())->first();
        if ($selectedActive) {
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
