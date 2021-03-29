<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\Option;
use App\Models\Suitability\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $options = Option::all();
        return view('suitability.options.index', compact('options'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $questions = Question::all();
        return view('suitability.options.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Option::create($request->all());
        session()->flash('success', 'Se ha añadido la opción correctamente.');
        return redirect()->route('suitability.options.index');
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
    public function edit(Option $option)
    {
        //
        $questions = Question::all();
        return view('suitability.options.edit', compact('questions', 'option'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        //
        $option->fill($request->all());
        $option->save();
        session()->flash('success', 'Se ha actualizado la opción correctamente.');
        return redirect()->route('suitability.options.index');
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
