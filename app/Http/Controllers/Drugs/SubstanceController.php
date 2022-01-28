<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\Substance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $substances = Substance::All()->SortBy(['presumed']);
        return view('drugs.substances.index')->withSubstances($substances);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drugs/substances/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $substance = new Substance($request->All());
      $substance->presumed = isset($request['presumed']);
      $substance->save();
      return redirect()->route('drugs.substances.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function show(Substance $substance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function edit(Substance $substance)
    {
        return view('drugs/substances/edit')->withSubstance($substance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drugs\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Substance $substance)
    {
      $substance->fill($request->all());
      $substance->presumed = isset($request['presumed']);
      $substance->save();

      return redirect()->route('drugs.substances.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drugs\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Substance $substance)
    {
        //
    }
}
