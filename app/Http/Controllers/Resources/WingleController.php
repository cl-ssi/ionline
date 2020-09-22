<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\Wingle;

class WingleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $wingles = Wingle::all();
      return view('resources.wingle.index', compact('wingles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('resources.wingle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $wingle = new Wingle($request->All());
      $wingle->save();
      session()->flash('info', 'El Wingle '.$wingle->brand.' ha sido creado.');
      return redirect()->route('resources.wingle.index');
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
    public function edit(Wingle $wingle)
    {
        return view('resources.wingle.edit', compact('wingle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wingle $wingle)
    {
      $wingle->fill($request->all());
      $wingle->save();
      session()->flash('success', 'El Wingle '.$wingle->brand.' ha sido actualizado.');
      return redirect()->route('resources.wingle.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wingle $wingle)
    {
      $wingle->delete();
      session()->flash('success', 'La Banda Ancha Móvil '.$wingle->brand.' ha sido eliminada.');
      return redirect()->route('resources.wingle.index');
    }
}
