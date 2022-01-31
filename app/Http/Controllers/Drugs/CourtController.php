<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\Court;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $court = Court::All()->SortBy('name');
        return view('drugs.courts.index')->withCourts($court);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drugs/courts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $court = new Court($request->All());
      $court->save();
      return redirect()->route('drugs.courts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function show(Court $court)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function edit(Court $court)
    {
        return view('drugs/courts/edit')->withCourt($court);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drugs\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Court $court)
    {
      $court->fill($request->all());
      $court->save();
      return redirect()->route('drugs.courts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drugs\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function destroy(Court $court)
    {
        //
    }
}
