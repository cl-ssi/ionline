<?php

namespace App\Http\Controllers\Rem;

use App\Models\Rem\RemPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $periods = RemPeriod::all();
        return view('rem.period.index', compact('periods'));
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
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(RemPeriod $remPeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(RemPeriod $remPeriod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RemPeriod $remPeriod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rem\RemPeriod  $remPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemPeriod $remPeriod)
    {
        //
    }
}
