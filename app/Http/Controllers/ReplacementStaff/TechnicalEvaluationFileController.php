<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\TechnicalEvaluationFile;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TechnicalEvaluationFileController extends Controller
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
    public function store(Request $request, TechnicalEvaluation $technicalEvaluation)
    {
        foreach ($request->file as $key_file => $file) {
            $files = new TechnicalEvaluationFile();

            $files->name = $request->input('name.'.$key_file.'');

            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $id_file = $key_file + 1;
            $file_name = $now.'_'.$id_file.'_'.$technicalEvaluation->id;
            $files->file = $file->storeAs('/ionline/replacement_staff/technical_evaluation_docs/', $file_name.'.'.$file->extension(), 'gcs');

            $files->user()->associate(auth()->user());
            $files->technicalEvaluation()->associate($technicalEvaluation);

            $files->save();
        }

        return redirect()
            ->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation->requestReplacementStaff).'#file')
            ->with('message-success-file', 'Estimado usuario, archivo(s) correctamente ingresado(s).');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnicalEvaluationFile  $technicalEvaluationFile
     * @return \Illuminate\Http\Response
     */
    public function show(TechnicalEvaluationFile $technicalEvaluationFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TechnicalEvaluationFile  $technicalEvaluationFile
     * @return \Illuminate\Http\Response
     */
    public function edit(TechnicalEvaluationFile $technicalEvaluationFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnicalEvaluationFile  $technicalEvaluationFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TechnicalEvaluationFile $technicalEvaluationFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnicalEvaluationFiles  $technicalEvaluationFiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnicalEvaluationFile $technicalEvaluationFile)
    {
        $technicalEvaluationFile->delete();
        Storage::delete($technicalEvaluationFile->file);

        return redirect()
            ->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluationFile->technicalEvaluation->requestReplacementStaff).'#file')
            ->with('message-danger-file', 'El archivo ha sido eliminado.');
    }

    public function download(TechnicalEvaluationFile $technicalEvaluationFile)
    {
        return Storage::download($technicalEvaluationFile->file);
    }

    public function show_file(TechnicalEvaluationFile $technicalEvaluationFile)
    {
        return Storage::response($technicalEvaluationFile->file);
    }
}
