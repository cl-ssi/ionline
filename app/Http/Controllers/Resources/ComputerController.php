<?php

namespace App\Http\Controllers\Resources;

use App\Resources\Computer;
use App\User;
use App\Parameters\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resources\StoreComputerRequest;
use App\Http\Requests\Resources\UpdateComputerRequest;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $computers = Computer::Search($request->get('search'))->paginate(50);
      return view('resources.computer.index', compact('computers'));
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
      return view('resources.computer.create', compact('users','places'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComputerRequest $request)
    {
      $computer = new computer($request->All());
      $computer->save();
      $computer->users()->sync($request->input('users'));
      session()->flash('info', 'El computador '.$computer->brand.' ha sido creado.');
      return redirect()->route('resources.computer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function show(Computer $computer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function edit(Computer $computer)
    {
      $users = User::OrderBy('name')->get();
      $places = Place::All();
      //$computer = new Computer;
      return view('resources.computer.edit', compact('computer', 'users','places'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComputerRequest $request, Computer $computer)
    {
      $computer->fill($request->all());
      $computer->save();
      $computer->users()->sync($request->input('users'));
      session()->flash('success', 'El computador '.$computer->brand.' ha sido actualizado.');
      return redirect()->route('resources.computer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Computer $computer)
    {
      $computer->delete();
      session()->flash('success', 'El computador '.$computer->brand.' ha sido eliminado');
      return redirect()->route('resources.computer.index');
    }
}
