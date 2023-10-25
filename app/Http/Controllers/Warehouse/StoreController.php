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


    public function indexCenabast(Request $request, $tray = null)
    {
        $query = Dte::query()
            ->where('cenabast', 1)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment->id);

        if ($tray === 'sin_adjuntar') {
            $query->whereNull('confirmation_signature_file');
        } elseif ($tray === 'adjuntados') {
            $query->whereNotNull('confirmation_signature_file');
        }

        if ($request->filled('id') || $request->filled('folio') || $request->filled('oc') || $request->filled('folio_compromiso') || $request->filled('folio_devengo')) {
            $query = $this->search($request);
        }

        $dtes = $query->paginate(100);
        $request->flash();

        return view('warehouse.stores.cenabast.index', compact('dtes', 'tray', 'request'));
    }

    /**
     * Save confirmation file
     *
     * @param  Request $request
     * @param  mixed $dte
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveFile(Request $request, $dte)
    {
        $file = $request->file('acta_' . $dte);
        $dte = Dte::findorFail($dte);
        if ($file and $dte) {
            $fileName = 'acta_' . $dte->id . '.' . $file->getClientOriginalExtension();
            $dte->confirmation_signature_file = $file->storeAs($this->filePath, $fileName, 'gcs');
            //  Se comenta ya que ahora al jefe poner la firma se da por confirmada
            // $dte->confirmation_status = 1;
            // $dte->confirmation_user_id = auth()->id();
            // $dte->confirmation_ou_id = auth()->user()->organizational_unit_id;
            // $dte->confirmation_at = now();
            $dte->save();
        }

        session()->flash('info', 'Se adjunto archivo/s con exito');
        return redirect()->route('warehouse.cenabast.index');
    }

    /**
     * Download a confirmation file
     *
     * @param  mixed $dte
     * @return mixed
     */
    public function downloadFile($dte)
    {
        $dte = Dte::findOrFail($dte);

        if (isset($dte->confirmation_signature_file)) {
            return Storage::disk('gcs')->download($dte->confirmation_signature_file);
        }
    }

    /**
     * Function for the callback
     *
     * @param Dte $dte
     * @param Request $request
     * @return void
     */
    public function callback(Dte $dte, Request $request)
    {
        if($request->is_pharmacist == true)
        {
            $dte->update([
                'cenabast_signed_pharmacist' => true,
            ]);
        }

        if($request->is_boss)
        {
            $dte->update([
                'confirmation_status' => 1,
                'cenabast_signed_boss' => 1,
                'confirmation_user_id' => auth()->id(),
                'confirmation_ou_id' => auth()->user()->organizational_unit_id,
                'confirmation_at' => now(),
            ]);
        }

        if(! isset($dte->cenabast_reception_file))
        {
            $dte->update([
                'cenabast_reception_file' => $request->cenabast_reception_file,
            ]);
        }

        session()->flash('success', 'La DTE fue firmada exitosamente.');
        return redirect()->route('warehouse.cenabast.index');
    }


    /**
     * Download the signed document
     *
     * @param  mixed $dte
     * @return mixed
     */
    public function downloadSigned($dte)
    {
        $dte = Dte::findOrFail($dte);

        if(isset($dte->cenabast_reception_file))
        {
            return Storage::disk('gcs')->download($dte->cenabast_reception_file);
        }
    }



    public function bypass(Request $request, $dte)
    {
        
        $dte = Dte::findorFail($dte);
        $dte->confirmation_status = 1;
        $dte->confirmation_user_id = auth()->id();
        $dte->confirmation_ou_id = auth()->user()->organizational_unit_id;
        $dte->confirmation_at = now();
        $dte->cenabast_signed_pharmacist = 1;
        $dte->cenabast_signed_boss =1;
        $dte->save();

        session()->flash('info', 'Se realizo bypass con exito');
        return redirect()->route('warehouse.cenabast.index');
    }



}
