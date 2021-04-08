<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Models\Parameters\UnitOfMeasurement;
use App\Http\Controllers\Controller;


class UnitOfMeasurementController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $measurements = UnitOfMeasurement::All();
      return view('parameters.measurements.index', compact('measurements'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('parameters.measurements.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $measurement = new UnitOfMeasurement($request->All());
      $measurement->save();

      session()->flash('info', 'La Unidad de Medida  '.$measurement->name.' ha sido creada.');

      return redirect()->route('parameters.measurements.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Parameters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(UnitOfMeasurement $measurement)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Parameters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit(UnitOfMeasurement $measurement)
  {
      return view('parameters.measurements.edit', compact('measurement'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Parameters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, UnitOfMeasurement $measurement)
  {
      $measurement->fill($request->all());
      $measurement->save();

      session()->flash('info', 'La Unidad de Medida  '.$measurement->name.' ha sido actualizada.');

      return redirect()->route('parameters.measurements.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Parameters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(UnitOfMeasurement $measurement)
  {
      //
  }

}
