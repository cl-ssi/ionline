<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Destiny;
use App\Models\User;

class DestinyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destines = Destiny::where('pharmacy_id',session('pharmacy_id'))
                                       ->orderBy('name', 'ASC')->paginate(50);
        return view('pharmacies.destines.index')->withDestines($destines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pharmacies.destines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $destiny = new Destiny($request->All());
        $destiny->pharmacy_id = session('pharmacy_id');
        $destiny->save();

        session()->flash('info', 'El destino '.$destiny->name.' ha sido creado.');
        return redirect()->route('pharmacies.destines.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharmacies\Destiny  $destiny
     * @return \Illuminate\Http\Response
     */
    public function show(Destiny $destiny)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Destiny  $destiny
     * @return \Illuminate\Http\Response
     */
    public function edit(Destiny $destiny)
    {
        $users = User::all();
        $users_selected = [];
        foreach($destiny->users as $user)
            $users_selected[] = $user->id;
        return view('pharmacies.destines.edit', compact('destiny', 'users', 'users_selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Destiny  $destiny
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destiny $destiny)
    {
        $destiny->fill($request->all());
        $destiny->save();

        $destiny->users()->sync($request->get('users_id'));

        session()->flash('info', 'El destino '.$destiny->name.' ha sido editado.');
        return redirect()->route('pharmacies.destines.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Destiny  $destiny
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destiny $destiny)
    {
        //
    }
}
