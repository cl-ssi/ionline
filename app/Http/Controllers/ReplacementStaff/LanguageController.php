<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
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
        foreach ($request->language as $key => $req) {
            $language = new language();
            $language->language = $request->input('language.'.$key.'');
            $language->level = $request->input('level.'.$key.'');
            $language->file = $request->input('file.'.$key.'');
            $language->replacement_staff()->associate($replacementStaff);
            $language->save();
        }
        session()->flash('success', 'Sus idiomas han sido correctamente ingresados.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, language $language)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(language $language)
    {
        //
    }
}
