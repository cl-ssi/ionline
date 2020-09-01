<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Parameters\PhraseOfTheDay;

class PhraseOfTheDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phrases = PhraseOfTheDay::latest()->get();
        return view('parameters.phrases.index', compact('phrases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parameters.phrases.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $phrase = new PhraseOfTheDay($request->All());
        $phrase->save();

        session()->flash('success', 'La frase ha sido creada');

        return redirect()->route('parameters.phrases.index');
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
    public function edit(PhraseOfTheDay $phrase)
    {
        return view('parameters.phrases.edit', compact('phrase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhraseOfTheDay $phrase)
    {
        $phrase->fill($request->all());
        $phrase->save();

        session()->flash('success', 'La frase ha sido actualizada');

        return redirect()->route('parameters.phrases.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
