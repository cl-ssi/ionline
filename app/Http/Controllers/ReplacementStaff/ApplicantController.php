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

        if ($request->missing('replacement_staff_id')) {
            return redirect()
              ->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation).'#applicant')
              ->with('message-danger-without-applicants', 'Estimado usuario, primero debe seleccionar postulante(s) al cargo');
        }
        else{
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
            return redirect()
                ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technical_evaluation_id).'#applicant')
                ->with('message-success-applicants', 'El postulante ha sido correctamente ingresado/s.');
        }
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

        // session()->flash('success', 'Calificación '.$applicant->score.' ingresada para: '.$applicant->replacement_staff->FullName);
        // return redirect()->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation).'#applicant');

        return redirect()
          ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technical_evaluation_id).'#applicant')
          ->with('message-success-evaluate-applicants', 'Calificación ingresada para: '.$applicant->replacement_staff->FullName);
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

        return redirect()
          ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technical_evaluation_id).'#applicant')
          ->with('message-danger-delete-applicants', 'Estimado usuario, primero debe seleccionar postulante(s) al cargo');
    }

    public function update_to_select(Request $request, Applicant $applicant)
    {
        foreach ($request->applicant_id as $key_file => $app_id) {
            $applicant_evaluated = Applicant::where('id', $app_id)->first();
            if($applicant_evaluated->psycholabor_evaluation_score == 0 || $applicant_evaluated->technical_evaluation_score == 0){
                return redirect()
                  ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation).'#applicant')
                  ->with('message-danger-aplicant-no-evaluated', 'Estimado usuario, favor ingresar evaluacion de todos los postulantes');
            }
        }

        // $applicant->fill($request->all());
        // $applicant->selected = 1;
        // $applicant->save();
        //
        // $technicalEvaluation = TechnicalEvaluation::Find($applicant->technical_evaluation)->first();
        // $now = Carbon::now();
        // $technicalEvaluation->date_end = $now;
        // $technicalEvaluation->technical_evaluation_status = 'complete';
        // $technicalEvaluation->save();

        session()->flash('success', 'El postulante ha sido seleccionado.');
        return redirect()->back();
    }
}
