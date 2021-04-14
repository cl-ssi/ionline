<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class TechnicalEvaluationController extends Controller
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
    public function store(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        $technicalEvaluation = new TechnicalEvaluation();
        // $date = Carbon::now();
        $technicalEvaluation->technical_evaluation_status = 'pending';
        $technicalEvaluation->user()->associate(Auth::user());
        $technicalEvaluation->organizational_unit_id = Auth::user()->organizationalUnit->id;
        $technicalEvaluation->request_replacement_staff_id = $requestReplacementStaff->id;
        $technicalEvaluation->save();

        session()->flash('success', 'Se ha creado Exitosamente el Proceso de Selección');
        return redirect()->route('replacement_staff.request.technical_evaluation.edit', compact('technicalEvaluation',
            'requestReplacementStaff'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnicalEvaluation  $technicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(TechnicalEvaluation $technicalEvaluation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TechnicalEvaluation  $technicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(TechnicalEvaluation $technicalEvaluation)
    {
        $users = User::orderBy('name', 'ASC')->get();
        return view('replacement_staff.request.technical_evaluation.edit', compact('technicalEvaluation', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnicalEvaluation  $technicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TechnicalEvaluation $technicalEvaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnicalEvaluation  $technicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnicalEvaluation $technicalEvaluation)
    {
        //
    }
}
