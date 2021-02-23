<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReplacementStaff\Training;
use App\Models\ReplacementStaff\ReplacementStaff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
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
            $training = new Training();
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_'.$i.'_'.$replacementStaff->run;
            $training->file = $file->storeAs('replacement_staff/training_docs', $file_name.'.'.$file->extension());
            $i++;
            foreach ($request->training_name as $req) {
                $training->training_name = $request->input('training_name.'.$key_file.'');
                $training->hours_training = $request->input('hours_training.'.$key_file.'');
                $training->replacement_staff()->associate($replacementStaff);
                //$profile->replacement_staff()->associate(Auth::user());
                $training->save();
            }
        }

        session()->flash('success', 'Su historial de Capacitaciones ha sido
        correctamente ingresada.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Training $training)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $training->delete();
        Storage::delete($training->file);

        session()->flash('danger', 'Su Capacitación ha sido eliminada.');
        return redirect()->back();
    }

    public function download(Training $training)
    {
        return Storage::download($training->file);
    }

    public function show_file(Training $training)
    {
        return Storage::response($training->file);
    }
}
