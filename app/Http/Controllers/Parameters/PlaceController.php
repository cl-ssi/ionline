<?php

namespace App\Http\Controllers\Parameters;

use App\Parameters\Place;
use App\Parameters\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::All();
        return view('parameters.places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::All();
        return view('parameters.places.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $place = new Place($request->All());
        $place->save();

        session()->flash('info', 'El lugar '.$place->name.' ha sido creado.');

        return redirect()->route('parameters.places.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parameters\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parameters\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        $locations = Location::All();
        return view('parameters.places.edit', compact('place','locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parameters\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        $place->fill($request->all());
        $place->save();

        session()->flash('info', 'El lugar '.$place->name.' ha sido actualizado.');

        return redirect()->route('parameters.places.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parameters\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}
