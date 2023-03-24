<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Warehouse\Store;
use App\Models\Warehouse\Control;
use App\Models\RequestForms\Invoice;
use App\Http\Controllers\Controller;

class ControlController extends Controller
{
    public function __construct()
    {
        $this->middleware('ensure.edit.control')->only('edit');
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
        if($request->type == 'receiving' || $request->type == 'dispatch')
        {
            $type = $request->type;
            $nav = $request->nav;
            return view('warehouse.controls.index', compact('store', 'type', 'nav'));
        }
        return redirect()->route('home');
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
        if($request->type == 'receiving' || $request->type == 'dispatch')
        {
            $type = $request->type;
            $nav = $request->nav;
            return view('warehouse.controls.create', compact('store', 'type', 'nav'));
        }
        return redirect()->route('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store, Control $control, Request $request)
    {
        $nav = $request->nav;
        if($control->isReceiveFromStore() && !$control->isConfirmed())
            return view('warehouse.controls.review-product', compact('store', 'control', 'nav'));
        else
            return view('warehouse.controls.edit', compact('store', 'control', 'nav'));
    }

    /**
     * Add product to Control
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Store $store, Control $control, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.controls.add-product', compact('store', 'control', 'nav'));
    }

    /**
     * Dispatch & Reception PDF report
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \App\Models\Warehouse\Control  $control
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pdf(Store $store, Control $control, Request $request)
    {
        $type = '/';
        $act_type = $request->act_type;

        if($control->isReceiving())
            return view('warehouse.pdf.report-reception', compact('store', 'control', 'type', 'act_type'));
        else
            return view('warehouse.pdf.report-dispatch', compact('store', 'control', 'type'));
    }

    /**
     * Generate Reception
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateReception(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.stores.generate-reception', compact('store', 'nav'));
    }

    /**
     * Invoice Manage
     *
     * @param  \App\Models\Warehouse\Store  $store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invoiceManage(Store $store, Request $request)
    {
        $nav = $request->nav;
        return view('warehouse.stores.manage-invoice', compact('store', 'nav'));
    }


    /**
    * Download Invoice
    */
    public function downloadInvoice(Invoice $invoice)
    {
        if(Storage::disk('gcs')->exists($invoice->url)) {
            return Storage::disk('gcs')->response($invoice->url);
        }else{
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado.');
        }
    }
}
