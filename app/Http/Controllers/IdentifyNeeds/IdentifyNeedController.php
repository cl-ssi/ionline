<?php

namespace App\Http\Controllers\IdentifyNeeds;

use App\Http\Controllers\Controller;

use App\Models\IdentifyNeeds\IdentifyNeed;
use Illuminate\Http\Request;
use App\Models\Documents\Approval;

class IdentifyNeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('identify_needs.index');
    }

    public function own_index()
    {
        return view('identify_needs.own_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('identify_needs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IdentifyNeeds\IdentifyNeed  $identifyNeed
     * @return \Illuminate\Http\Response
     */
    public function show(IdentifyNeed $identifyNeed)
    {
        //
    }

    public function show_approval($identify_need_id)
    {
        $identifyNeed = IdentifyNeed::find($identify_need_id);
        return view('identify_needs.show_approval', compact('identifyNeed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IdentifyNeeds\IdentifyNeed  $identifyNeed
     * @return \Illuminate\Http\Response
     */
    public function edit(IdentifyNeed $identifyNeed)
    {
        return view('identify_needs.edit', compact('identifyNeed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IdentifyNeeds\IdentifyNeed  $identifyNeed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IdentifyNeed $identifyNeed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IdentifyNeeds\IdentifyNeed  $identifyNeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdentifyNeed $identifyNeed)
    {
        //
    }

     /**
     * Función callback para aprobaciones 
     */
    public function approvalCallback($approval_id, $identify_need_id, $process){
        $approval = Approval::find($approval_id);
        $identifyNeed = IdentifyNeed::find($identify_need_id);

        /* Aprueba */
        if($approval->status == 1){
            if($process == 'end'){
                $identifyNeed->status = 'completed';
                $identifyNeed->save();
            }
        }   

        /* Rechaza */
        if($approval->status == 0){
            $identifyNeed->status = 'rejected';
            $identifyNeed->save();
        }
    }
}
