<?php

namespace App\Http\Controllers\Parameters;

use App\Models\Parameters\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Establishment;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function index(Establishment $establishment)
    {
        $locations = Location::whereEstablishmentId($establishment->id)->get();
        return view('parameters.locations.index', compact('locations', 'establishment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function create(Establishment $establishment)
    {
        return view('parameters.locations.create', compact('establishment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Establishment  $establishment
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Establishment $establishment, Request $request)
    {
        $location = new Location($request->All());
        $location->establishment_id = $establishment->id;
        $location->save();

        session()->flash('info', 'La ubicación  ' . $location->name . ' ha sido creada.');

        return redirect()->route('parameters.locations.index', $establishment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Establishment  $establishment
     * @param  \App\Models\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Establishment $establishment, Location $location)
    {
        return view('parameters.locations.edit', compact('location', 'establishment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Establishment $establishment
     * @param  \App\Models\Parameters\Location  $location
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Establishment $establishment, Location $location, Request $request)
    {
        $location->fill($request->all());
        $location->save();

        session()->flash('info', 'La ubicación ' . $location->name . ' ha sido actualizada.');

        return redirect()->route('parameters.locations.index', $establishment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
