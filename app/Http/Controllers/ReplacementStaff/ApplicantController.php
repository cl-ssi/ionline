<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\Applicant;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApplicantController extends Controller
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
        foreach ($request->replacement_staff_id as $key_file => $req) {
            $exist = Applicant::where('replacement_staff_id', $req)->
                Where('technical_evaluation_id', $technicalEvaluation->id)->
                get();
            if($exist->isEmpty()){
                $applicant = new Applicant();
                $applicant->replacement_staff_id = $req;
                $applicant->technical_evaluation()->associate($technicalEvaluation);
                $applicant->save();
            }
        }
        session()->flash('success', 'El postulante ha sido correctamente ingresado/s.');
        return redirect()->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation).'#applicant');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Applicant $applicant)
    {
        $applicant->fill($request->all());
        $applicant->save();

        session()->flash('success', 'Calificación '.$applicant->score.' ingresada para: '.$applicant->replacement_staff->FullName);
        return redirect()->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technical_evaluation).'#applicant');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        $applicant->delete();

        session()->flash('danger', 'El postulante ha sido eliminado.');
        return redirect()->back();
    }

    public function update_to_select(Request $request, Applicant $applicant)
    {
        $applicant->fill($request->all());
        $applicant->selected = 1;
        $applicant->save();

        $technicalEvaluation = TechnicalEvaluation::Find($applicant->technical_evaluation)->first();
        $now = Carbon::now();
        $technicalEvaluation->date_end = $now;
        $technicalEvaluation->technical_evaluation_status = 'complete';
        $technicalEvaluation->save();

        session()->flash('success', 'El postulante ha sido seleccionado.');
        return redirect()->back();
    }
}
