<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Accountability;
use App\Agreements\Agreement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Agreement $agreement)
    {
        $accountabilities = Accountability::Where('agreement_id', $agreement->id)->get();
        return view('agreements.accountability.index', compact('accountabilities' ,'agreement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Agreement $agreement)
    {
        return view('agreements.accountability.create', compact('agreement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Agreement $agreement)
    {
        $accountability = new Accountability($request->All());
        $accountability->agreement()->associate($agreement);
        $accountability->save();

        session()->flash('info', 'La rendición ha sido creada.');

        return redirect()->route('agreements.accountability.index', $agreement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreements\Accountability  $accountability
     * @return \Illuminate\Http\Response
     */
    public function show(Accountability $accountability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreements\Accountability  $accountability
     * @return \Illuminate\Http\Response
     */
    public function edit(Accountability $accountability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreements\Accountability  $accountability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accountability $accountability)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agreements\Accountability  $accountability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accountability $accountability)
    {
        //
    }
}
