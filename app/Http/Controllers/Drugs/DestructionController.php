<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\Destruction;
use App\Models\Drugs\Reception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Parameters\Parameter;

class DestructionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Lista todas las destrucciones */
        $destructions = Destruction::latest()->get()->groupBy(function ($item) {
            return $item->destructed_at->format('d-m-Y');
        });

        return view('drugs.destructions.index', compact('destructions'));
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
        $destruction = new Destruction($request->All());
        $destruction->user()->associate(Auth::user());
        $destruction->manager_id  = Parameter::get('drugs','Jefe')->value;
        $destruction->lawyer_id   = Parameter::get('drugs','Mandatado')->value;
        $destruction->observer_id = empty(Parameter::get('drugs','MinistroDeFe')->value) ? null : Parameter::get('drugs','MinistroDeFe')->value;
        $destruction->lawyer_observer_id = Parameter::get('drugs','MinistroDeFeJuridico')->value;
        //dd($destruction);
        $destruction->save();
        return redirect()->route('drugs.receptions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\Destruction  $destruction
     * @return \Illuminate\Http\Response
     */
    public function show(Destruction $destruction)
    {
        return view('drugs.destructions.show')->withDestruction($destruction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\Destruction  $destruction
     * @return \Illuminate\Http\Response
     */
    public function edit(Destruction $destruction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drugs\Destruction  $destruction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destruction $destruction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drugs\Destruction  $destruction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destruction $destruction)
    {
        $destruction->delete();
        session()->flash('success', 'La destrucción con fecha '.$destruction->destructed_at->format('d-m-Y').' ha sido eliminada.');
        return redirect()->route('drugs.receptions.show', $destruction->reception->id);
    }
}
