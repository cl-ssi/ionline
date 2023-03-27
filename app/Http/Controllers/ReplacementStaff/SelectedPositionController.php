<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\SelectedPosition;
use Illuminate\Http\Request;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use Carbon\Carbon;

class SelectedPositionController extends Controller
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
        foreach($request->position_id as $key => $selectedPosition) {
            $newSelectedPosition = new SelectedPosition();
            $newSelectedPosition->position_id   = $request->position_id[$key];
            $newSelectedPosition->run           = $request->run[$key];
            $newSelectedPosition->dv            = $request->dv[$key];
            $newSelectedPosition->name          = $request->name[$key];
            $newSelectedPosition->save();
        }

        $technicalEvaluation->date_end = now();
        $technicalEvaluation->technical_evaluation_status = 'complete';
        $technicalEvaluation->save();

        $technicalEvaluation->requestReplacementStaff->request_status = 'complete';
        $technicalEvaluation->requestReplacementStaff->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReplacementStaff\SelectedPosition  $selectedPosition
     * @return \Illuminate\Http\Response
     */
    public function show(SelectedPosition $selectedPosition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReplacementStaff\SelectedPosition  $selectedPosition
     * @return \Illuminate\Http\Response
     */
    public function edit(SelectedPosition $selectedPosition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReplacementStaff\SelectedPosition  $selectedPosition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SelectedPosition $selectedPosition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReplacementStaff\SelectedPosition  $selectedPosition
     * @return \Illuminate\Http\Response
     */
    public function destroy(SelectedPosition $selectedPosition)
    {
        //
    }
}
