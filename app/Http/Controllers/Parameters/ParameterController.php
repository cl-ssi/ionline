<?php

namespace App\Http\Controllers\Parameters;

use App\Models\Parameters\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParameterController extends Controller
{
    /**
     * Display welcome view of parameters.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $parameters = Parameter::where('module','Drugs')->get();
        return view('parameters.welcome')->withParameters($parameters);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDrugs()
    {
        return view('drugs.parameters');
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
     * @param  \App\Models\Parameters\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parameters\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parameters\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter)
    {
        $parameter->fill($request->all());
        $parameter->save();
        session()->flash('success', 'Parametro: '.$parameter->parameter.' ha sido actualizado.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameters\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        //
    }
}
