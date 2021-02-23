<?php

namespace App\Http\Controllers\ReplacementStaff;

use Illuminate\Http\Request;
use App\Models\ReplacementStaff\Experience;
use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\ReplacementStaff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request, ReplacementStaff $replacementStaff)
    {
        $files = $request->file('file');

        if($request->hasFile('file'))
        {
            $i = 1;
            foreach ($files as $key_file => $file) {
                $experience = new Experience();
                $now = Carbon::now()->format('Y_m_d_H_i_s');
                $file_name = $now.'_'.$i.'_'.$replacementStaff->run;
                $experience->file = $file->storeAs('replacement_staff/experience_docs', $file_name.'.'.$file->extension());
                $i++;
                foreach ($request->previous_experience as $req) {
                    $experience->previous_experience = $request->input('previous_experience.'.$key_file.'');
                    $experience->performed_functions = $request->input('performed_functions.'.$key_file.'');
                    $experience->contact_name = $request->input('contact_name.'.$key_file.'');
                    $experience->contact_telephone = $request->input('contact_telephone.'.$key_file.'');
                    $experience->replacement_staff()->associate($replacementStaff);
                    //$profile->replacement_staff()->associate(Auth::user());
                    $experience->save();
                }
            }
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
        $experience->delete();
        Storage::delete($experience->file);

        session()->flash('danger', 'Su Experiencia Profesional ha sido eliminada.');
        return redirect()->back();
    }

    public function download(Experience $experience)
    {
        return Storage::download($experience->file);
    }

    public function show_file(Experience $experience)
    {
        return Storage::response($experience->file);
    }
}
