<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Parameters\Location;
use App\Models\ServiceRequests\Denomination1121;

class Denomination1121Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $denominations1121 = Denomination1121::All();
        return view('service_requests.parameters.1121.index', compact('denominations1121'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service_requests.parameters.1121.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $denomination1121 = new Denomination1121($request->All());
        $denomination1121->save();

        session()->flash('info', 'La Denominación  '.$denomination1121->code.' ha sido creada.');

        return redirect()->route('rrhh.service-request.parameters.1121.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameters\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceRequests\Denomination1121  $denomination1121
     * @return \Illuminate\Http\Response
     */
    public function edit(Denomination1121 $denomination1121)
    {
        return view('service_requests.parameters.1121.edit', compact('denomination1121'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceRequests\Denomination1121  $denomination1121
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Denomination1121 $denomination1121)
    {
        $location->fill($request->all());
        $location->save();

        session()->flash('info', 'La ubicación  '.$location->name.' ha sido actualizada.');

        return redirect()->route('service_request.parameters.1121.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceRequests\Denomination1121  $denomination1121
     * @return \Illuminate\Http\Response
     */
    public function destroy(Denomination1121 $denomination1121)
    {
        //
    }
}
