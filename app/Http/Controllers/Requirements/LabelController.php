<?php

namespace App\Http\Controllers\Requirements;

//use App\Models\Requirements\RequirementLabel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Requirements\Label;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Auth::User()->reqLabels;
        //$labels = Label::where('user_id',Auth::id())
        return view('requirements.labels.index',compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$establishments = Establishment::orderBy('name','ASC')->get();
        return view('requirements.labels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $label = new Label($request->all());
        //$dispatch->pharmacy_id = session('pharmacy_id');
        $label->user_id = Auth::id();
        $label->save();

        session()->flash('success', 'Se ha guardado la etiqueta.');
        return redirect()->route('requirements.labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requirements\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requirements\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        //$labels = Label::All();
        //$programs = Program::All();
        return view('requirements.labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requirements\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $label->fill($request->all());
        $label->save();

        session()->flash('info', 'La etiqueta '.$label->name.' ha sido editada.');
        return redirect()->route('requirements.labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requirements\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        //
    }
}
