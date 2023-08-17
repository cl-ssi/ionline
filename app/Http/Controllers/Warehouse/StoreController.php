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

    public $filePath = '/ionline/cenabast';
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


    public function indexCenabast($tray = null)
    {
        $query = Dte::where('cenabast', 1);

        if ($tray === 'sin_adjuntar') {
            $query->whereNull('confirmation_signature_file');
        } elseif ($tray === 'adjuntados') {
            $query->whereNotNull('confirmation_signature_file');
        }

        $dtes = $query->get();

        return view('warehouse.stores.cenabast.index', compact('dtes', 'tray'));
    }


    public function saveFile(Request $request, $dte)
    {
        $file = $request->file('acta_' . $dte);
        $dte = Dte::findorFail($dte);
        if ($file and $dte) {
            $fileName = 'acta_' . $dte->id . '.' . $file->getClientOriginalExtension();
            $dte->confirmation_signature_file = $file->storeAs($this->filePath, $fileName, 'gcs');
            $dte->confirmation_status = 1;
            $dte->confirmation_user_id = auth()->id();
            $dte->confirmation_ou_id = auth()->user()->organizational_unit_id;
            $dte->confirmation_at = now();
            $dte->save();
        }

        session()->flash('info', 'Se adjunto archivo/s con exito');
        return redirect()->route('warehouse.cenabast.index');
    }


    public function downloadFile($dte)
    {
        $dte = Dte::findOrFail($dte);

        if ($dte->confirmation_signature_file) {
            return Storage::disk('gcs')->download($dte->confirmation_signature_file);
        }
    }


    public function deleteFile($dte)
    {
        $dte = Dte::findOrFail($dte);

        if ($dte->confirmation_signature_file) {
            Storage::disk('gcs')->delete($dte->confirmation_signature_file);
            $dte->confirmation_signature_file = null;
            $dte->save();

            session()->flash('info', 'Se borró el archivo con éxito');
        } else {
            session()->flash('error', 'El archivo no existe');
        }

        return redirect()->route('warehouse.cenabast.index');
    }
}
