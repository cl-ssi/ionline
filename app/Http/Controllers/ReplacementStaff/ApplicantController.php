<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\Applicant;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        foreach ($request->user_id as $key_file => $req) {
            $exist = Applicant::where('user_id', $req)->
                Where('technical_evaluation_id', $technicalEvaluation->id)->
                get();

            if($exist->isEmpty()){
                $applicant = new Applicant();
                $applicant->user_id = $req;
                $applicant->technicalEvaluation()->associate($technicalEvaluation);
                $applicant->save();
            }

            session()->flash('success', 'El postulante ha sido correctamente ingresado/s.');
            return redirect()->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation).'#applicant');

            // return redirect()->to(route('replacement_staff.request.technical_evaluation.applicant').'#applicant');

            // $applicant = new Applicant();
            //
            // $commission->user_id = $req;
            // $commission->job_title = $request->input('job_title.'.$key_file.'');
            //
            // $user_ou = User::where('id', $commission->user_id)->first();
            // $commission->organizational_unit_id = $user_ou->organizationalUnit->id;
            //
            // $commission->technicalEvaluation()->associate($technicalEvaluation);
            // $commission->save();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        //
    }
}
