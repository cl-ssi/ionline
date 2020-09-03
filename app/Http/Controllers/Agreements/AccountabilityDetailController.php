<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\AccountabilityDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agreements\Agreement;
use App\Agreements\Accountability;

class AccountabilityDetailController extends Controller
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
    public function create(Agreement $agreement, Accountability $accountability)
    {
        return view('agreements.accountability.detail.create', compact('agreement', 'accountability'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Agreement $agreement, Accountability $accountability)
    {
        $accountabilityDetail = new AccountabilityDetail($request->All());
        $accountabilityDetail->accountability()->associate($accountability);
        $accountabilityDetail->save();

        return redirect()->route('agreements.accountability.detail.create', [$agreement, $accountability]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreements\AccountabilityDetail  $accountabilityDetail
     * @return \Illuminate\Http\Response
     */
    public function show(AccountabilityDetail $accountabilityDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreements\AccountabilityDetail  $accountabilityDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountabilityDetail $accountabilityDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreements\AccountabilityDetail  $accountabilityDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountabilityDetail $accountabilityDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agreements\AccountabilityDetail  $accountabilityDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountabilityDetail $accountabilityDetail)
    {
        //
    }
}
