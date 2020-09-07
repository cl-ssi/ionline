<?php

namespace App\Http\Controllers\Parameters;

use App\Parameters\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::All();
        return view('parameters.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parameters.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = new Location($request->All());
        $location->save();

        session()->flash('info', 'La ubicación  '.$location->name.' ha sido creada.');

        return redirect()->route('parameters.locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('parameters.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $location->fill($request->all());
        $location->save();

        session()->flash('info', 'La ubicación  '.$location->name.' ha sido actualizada.');

        return redirect()->route('parameters.locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
