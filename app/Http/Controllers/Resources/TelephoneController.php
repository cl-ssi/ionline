<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resources\Telephone;
use App\Http\Requests\Resources\UpdateTelephoneRequest;
use App\Http\Requests\Resources\StoreTelephoneRequest;
use App\Http\Controllers\Controller;

class TelephoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $telephones = Telephone::with([
                'users',
                'place',
            ])
            ->search($request->get('search'))
            ->paginate(300);

        return view('resources.telephone.index', compact('telephones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources.telephone.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTelephoneRequest $request)
    {
        $telephone = new Telephone($request->All());
        $telephone->save();
        $telephone->users()->sync($request->input('users'));
        session()->flash('info', 'El telefono ' . $telephone->number . ' ha sido creado.');
        return redirect()->route('resources.telephone.index');
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
    public function edit(Telephone $telephone)
    {
        return view('resources.telephone.edit', compact('telephone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTelephoneRequest $request, Telephone $telephone)
    {
        $telephone->fill($request->all());
        $telephone->save();
        $telephone->users()->sync($request->input('users'));
        session()->flash('success', 'El telefono ' . $telephone->number . ' ha sido actualizado.');
        return redirect()->route('resources.telephone.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Telephone $telephone)
    {
        /** Eliminar todos los usurios asociados al telefono */
        $telephone->users()->detach();
        /** Borrar el telefono */
        $telephone->delete();

        session()->flash('success', 'El telefono ' . $telephone->number . ' ha sido eliminado.');
        return redirect()->route('resources.telephone.index');
    }
}
