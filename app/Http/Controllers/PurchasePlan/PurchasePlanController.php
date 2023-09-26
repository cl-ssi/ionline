<?php

namespace App\Http\Controllers\PurchasePlan;

use App\Models\PurchasePlan\PurchasePlan;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class PurchasePlanController extends Controller
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

    public function own_index()
    {
        return view('purchase_plan.own_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase_plan.create');
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
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function show(PurchasePlan $purchasePlan)
    {
        return view('purchase_plan.show', compact('purchasePlan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchasePlan $purchasePlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchasePlan $purchasePlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchasePlan $purchasePlan)
    {
        //
    }
}
