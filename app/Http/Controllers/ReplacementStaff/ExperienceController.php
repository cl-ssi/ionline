<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReplacementStaff\Experience;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $replacementStaff)
    {
        foreach ($request->previous_experience as $key => $req) {
            $experience = new Experience();
            $experience->previous_experience = $request->input('previous_experience.'.$key.'');
            $experience->performed_functions = $request->input('performed_functions.'.$key.'');
            $experience->file = $request->input('file.'.$key.'');
            $experience->contact_name = $request->input('contact_name.'.$key.'');
            $experience->contact_telephone = $request->input('contact_telephone.'.$key.'');
            $experience->replacement_staff()->associate($replacementStaff);
            $experience->save();
        }
        session()->flash('success', 'Su perfil Experiencia Profesional ha sido
        correctamente ingresada.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        //
    }
}
