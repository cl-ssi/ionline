<?php

namespace App\Http\Controllers\JobPositionProfiles;

use App\Models\JobPositionProfiles\JobPositionProfile;
use App\Models\JobPositionProfiles\JobPositionProfileSign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parameters\Parameter;

class JobPositionProfileSignController extends Controller
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
    public function store(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jpp_review = new JobPositionProfileSign();
        $jpp_review->position = 1;
        $jpp_review->event_type = 'review';
        $jpp_review->status = 'pending';
        $jpp_review->job_position_profile_id = $jobPositionProfile->id;
        $jpp_review->organizational_unit_id = Parameter::where('module', 'ou')->where('parameter', 'GestionDesarrolloDelTalento')->first()->value;
        $jpp_review->save();

        $jpp_esing = new JobPositionProfileSign();
        $jpp_esing->position = 2;
        $jpp_esing->event_type = 'esign';
        $jpp_esing->job_position_profile_id = $jobPositionProfile->id;
        $jpp_esing->organizational_unit_id = $jobPositionProfile->organizationalUnit->id;
        $jpp_esing->save();
        
        $jobPositionProfile->status = 'review';
        $jobPositionProfile->save();

        session()->flash('success', 'Estimado Usuario, se ha enviado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPositionProfiles\JobPositionProfileSign  $jobPositionProfileSign
     * @return \Illuminate\Http\Response
     */
    public function show(JobPositionProfileSign $jobPositionProfileSign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobPositionProfiles\JobPositionProfileSign  $jobPositionProfileSign
     * @return \Illuminate\Http\Response
     */
    public function edit(JobPositionProfileSign $jobPositionProfileSign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPositionProfiles\JobPositionProfileSign  $jobPositionProfileSign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPositionProfileSign $jobPositionProfileSign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPositionProfiles\JobPositionProfileSign  $jobPositionProfileSign
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPositionProfileSign $jobPositionProfileSign)
    {
        //
    }
}
