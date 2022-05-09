<?php

namespace App\Http\Controllers\RequestForms;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\InternalPurchaseOrder;
use App\Models\RequestForms\PurchasingProcessDetail;
use Illuminate\Http\Request;

class InternalPurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InternalPurchaseOrder  $internalPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(InternalPurchaseOrder $internalPurchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InternalPurchaseOrder  $internalPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(InternalPurchaseOrder $internalPurchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InternalPurchaseOrder  $internalPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InternalPurchaseOrder $internalPurchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InternalPurchaseOrder  $internalPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(InternalPurchaseOrder $internalPurchaseOrder)
    {
        //
    }

    public function create_internal_purchase_order_document(PurchasingProcessDetail $purchasingProcessDetail)
    {
        $purchasingProcessDetail->load('user', 'internalPurchaseOrder.supplier', 'purchasingProcess.requestForm');
        $details = PurchasingProcessDetail::where('internal_purchase_order_id', $purchasingProcessDetail->internal_purchase_order_id)->get();
        // return $details;
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('request_form.documents.internal_purchase_order_document', compact('purchasingProcessDetail', 'details'));

        return $pdf->stream('oc_'.$purchasingProcessDetail->internal_purchase_order_id.'.pdf');
    }
}
