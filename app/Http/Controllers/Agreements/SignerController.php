<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Signer;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class SignerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signers = Signer::with('user')->orderBy('created_at', 'DESC')->get();
        $users = User::all();
        return view('agreements.signers.index', compact('signers', 'users'));
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
        Signer::create($request->all());
        return redirect()->route('agreements.signers.index')->with('success', 'Se han guardado el nuevo firmante satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function show(Signer $signer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function edit(Signer $signer)
    {
        $users = User::all();
        return view('agreements.signers.edit', compact('signer', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signer $signer)
    {
        $signer->update($request->all());
        return redirect()->route('agreements.signers.index')->with('success', 'Se han guardado los cambios del firmante');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Signer  $signer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signer $signer)
    {
        //
    }
}
