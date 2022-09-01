<?php

namespace App\Http\Controllers\Parameters;

use App\Models\Parameters\CutOffDate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CutOffDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        $cut_off_dates = CutOffDate::where('year', $year)->orderBy('number')->get();
        return view('parameters.cutoffdates.index', compact('cut_off_dates', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $year = $request->year;
        return view('parameters.cutoffdates.create', compact('year'));
    }

    public function store(Request $request)
    {
        $cutOffDateExist = CutOffDate::where('year', $request->year)->where('number', $request->number)->count();

        if($cutOffDateExist){
            session()->flash('danger', 'Fecha de corte creado con anterioridad.');
            return redirect()->back()->withInput();
        }
        
        CutOffDate::create($request->all());
        session()->flash('success', 'Fecha de corte ha sido creado satistactoriamente.');
        return redirect()->route('parameters.cutoffdates.index', ['year' => $request->year]);
    }

    public function show(CutOffDate $cut_off_date)
    {
        //
    }

    public function edit(CutOffDate $cut_off_date)
    {
        return view('parameters.cutoffdates.edit', compact('cut_off_date'));
    }

    public function update(Request $request, CutOffDate $cut_off_date)
    {
        $cut_off_date->update($request->all());
        session()->flash('info', 'La fecha de corte ha sido actualizado correctamente.');
        return redirect()->route('parameters.cutoffdates.index', ['year' => $request->year]);
    }

    public function destroy(CutOffDate $cut_off_date)
    {
        $cut_off_date->delete();
        session()->flash('info', 'La fecha de corte ha sido eliminado correctamente.');
        return redirect()->back();
    }
}
