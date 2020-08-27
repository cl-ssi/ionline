<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacies\Establishment;
use App\User;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                       ->orderBy('name', 'ASC')->paginate(50);
        return view('pharmacies.establishments.index')->withEstablishments($establishments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pharmacies.establishments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $establishment = new Establishment($request->All());
        $establishment->pharmacy_id = session('pharmacy_id');
        $establishment->save();

        session()->flash('info', 'El establecimiento '.$establishment->name.' ha sido creado.');
        return redirect()->route('pharmacies.establishments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacies\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function show(Establishment $establishment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacies\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function edit(Establishment $establishment)
    {
        $users = User::all();
        $users_selected = [];
        foreach($establishment->users as $user)
            $users_selected[] = $user->id;
        return view('pharmacies.establishments.edit', compact('establishment', 'users', 'users_selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacies\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establishment $establishment)
    {
        $establishment->fill($request->all());
        $establishment->save();

        $establishment->users()->sync($request->get('users_id'));

        session()->flash('info', 'El establecimiento '.$establishment->name.' ha sido editado.');
        return redirect()->route('pharmacies.establishments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacies\Establishment  $establishment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establishment $establishment)
    {
        //
    }
}
