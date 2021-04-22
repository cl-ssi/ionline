<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequests\Value;
use App\Establishment;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $values = Value::all();
        return view('parameters.values.index', compact('values'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $establishments = Establishment::all();
        return view('parameters.values.create',compact('establishments'));
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
        $value = new Value($request->All());
        $value->save();
        session()->flash('info', 'El valor de la Jornada/Hora ha sido creado');
        return redirect()->route('parameters.values.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceRequests\HourValue  $hourValue
     * @return \Illuminate\Http\Response
     */
    public function show(Value $value)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceRequests\HourValue  $hourValue
     * @return \Illuminate\Http\Response
     */
    public function edit(Value $value)
    {
        //
        $establishments = Establishment::all();
        return view('parameters.values.edit', compact('value','establishments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceRequests\HourValue  $hourValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Value $value)
    {
        //
        $value->fill($request->all());
        $value->save();
        session()->flash('info', 'El valor de la Jornada/Hora ha sido Actualizado');
        return redirect()->route('parameters.values.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceRequests\HourValue  $hourValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(HourValue $hourValue)
    {
        //
    }
}
