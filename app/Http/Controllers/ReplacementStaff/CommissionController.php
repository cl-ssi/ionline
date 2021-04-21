<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\Commission;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Rrhh\Authority;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CommissionController extends Controller
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
            $commission = new Commission();
            $commission->user_id = $req;
            $commission->job_title = $request->input('job_title.'.$key_file.'');

            $user_ou = User::where('id', $commission->user_id)->first();
            $commission->organizational_unit_id = $user_ou->organizationalUnit->id;

            $commission->technicalEvaluation()->associate($technicalEvaluation);
            $commission->save();
        }

        session()->flash('success', 'Integrantes de Comisión ha/n sido correctamente ingresado/s.');
        return redirect()->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation).'#commission');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        $commission->delete();

        session()->flash('danger', 'El Integrante de Comisión ha sido eliminado de la Evaluación Técnica.');
        return redirect()->back();
    }
}
