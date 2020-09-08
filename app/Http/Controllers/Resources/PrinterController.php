<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\Printer;
use App\User;
use App\Parameters\Place;
use App\Http\Requests\Resources\StorePrinterRequest;
use App\Http\Requests\Resources\UpdatePrinterRequest;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $printers = Printer::Search($request->get('search'))->paginate(50);
      return view('resources.printer.index', compact('printers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $users = User::OrderBy('name')->get();
      $places = Place::All();
      return view('resources.printer.create', compact('users','places'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrinterRequest $request)
    {
      $printer = new Printer($request->All());
      $printer->save();
      $printer->users()->sync($request->input('users'));
      session()->flash('info', 'Impresora '.$printer->brand.' ha sido creada.');
      return redirect()->route('resources.printer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Printer $printer)
    {
      $users = User::OrderBy('name')->get();
      $places = Place::All();
      return view('resources.printer.edit', compact('printer', 'users','places'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrinterRequest $request, Printer $printer)
    {
      $printer->fill($request->all());
      $printer->save();
      $printer->users()->sync($request->input('users'));
      session()->flash('success', 'La impresora '.$printer->brand.' ha sido actualizada.');
      return redirect()->route('resources.printer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Printer $printer)
    {
      $printer->delete();
      session()->flash('success', 'La Impresora '.$printer->brand.' ha sido eliminada');
      return redirect()->route('resources.printer.index');
    }
}
