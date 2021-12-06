<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\RequestForms\SupplyPurchase;
use Illuminate\Http\Request;

use App\Models\RequestForms\RequestForm;
use App\User;

use App\Http\Controllers\Controller;

class SupplyPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //By Purchser
        if(Auth()->user()->organizational_unit_id == 37){
            $purchaser = User::with('requestForms')
                ->latest()
                ->whereHas('requestForms', function ($q){
                    $q->where('status', 'approved');
                })
                ->where('id', Auth()->user()->id)
                ->first();

            return view('request_form.purchase.index', compact('purchaser'));
        }
        else{
          session()->flash('danger', 'Estimado Usuario/a: Usted no pertence a la Unidad de Abastecimiento.');
          return redirect()->route('request_forms.my_forms');
        }

    }

    public function purchase(RequestForm $requestForm)
    {
        return view('request_form.purchase.purchase', compact('requestForm'));
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
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
