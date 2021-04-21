<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\ProfessionManage;
use App\Models\ReplacementStaff\ProfileManage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Redirect;

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
    public function edit(Request $request, TechnicalEvaluation $technicalEvaluation)
    {
        $users = User::orderBy('name', 'ASC')->get();

        $replacementStaff = ReplacementStaff::search($request->input('search'),
                                                     $request->input('profile_search'),
                                                     $request->input('profession_search'))
            ->paginate(15);

        $professionManage = ProfessionManage::orderBy('name', 'ASC')->get();
        $profileManage = ProfileManage::orderBy('name', 'ASC')->get();

        if($request->search != NULL || $request->profile_search != 0 || $request->profession_search != 0){
            return view('replacement_staff.request.technical_evaluation.edit',
                compact('technicalEvaluation', 'users', 'request', 'replacementStaff',
                        'professionManage', 'profileManage'));
        }
        else{
            return view('replacement_staff.request.technical_evaluation.edit',
                compact('technicalEvaluation', 'users', 'request', 'replacementStaff',
                        'professionManage', 'profileManage'));
        }
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
