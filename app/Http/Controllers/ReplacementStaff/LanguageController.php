<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReplacementStaff\Language;
use App\Models\ReplacementStaff\ReplacementStaff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request, ReplacementStaff $replacementStaff)
    {
        $files = $request->file('file');
        $i = 1;
        foreach ($files as $key_file => $file) {
            $lenguage = new Language();
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_'.$i.'_'.$replacementStaff->run;
            $lenguage->file = $file->storeAs('replacement_staff/lenguage_docs', $file_name.'.'.$file->extension());
            $i++;
            foreach ($request->language as $req) {
                $lenguage->language = $request->input('language.'.$key_file.'');
                $lenguage->level = $request->input('level.'.$key_file.'');
                $lenguage->replacement_staff()->associate($replacementStaff);
                //$profile->replacement_staff()->associate(Auth::user());
                $lenguage->save();
            }
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
        $language->delete();
        Storage::delete($language->file);

        session()->flash('danger', 'Su Idioma ha sido eliminada.');
        return redirect()->back();
    }

    public function download(Language $language)
    {
        return Storage::download($language->file);
    }

    public function show_file(Language $language)
    {
        return Storage::response($language->file);
    }
}
