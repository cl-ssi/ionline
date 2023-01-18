<?php

namespace App\Http\Controllers\JobPositionProfiles;

use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\StaffDecree;
use App\Models\Parameters\StaffDecreeByEstament;
use App\Models\JobPositionProfiles\Role;



class JobPositionProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('job_position_profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('job_position_profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $jobPositionProfile = new JobPositionProfile($request->All());
        $jobPositionProfile->status = 'pending';
        $jobPositionProfile->user()->associate(Auth::user());
        $jobPositionProfile->organizationalUnit()->associate($request->ou_creator_id);
        $jobPositionProfile->estament()->associate($request->estament_id);
        $jobPositionProfile->area()->associate($request->area_id);
        $jobPositionProfile->contractualCondition()->associate($request->contractual_condition_id);

        $jobPositionProfile->save();

        session()->flash('success', 'Estimado Usuario, se ha creado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.edit', $jobPositionProfile);

        //return view('job_position_profile.edit', compact('jobPositionProfile'))->with('success', 'Estimados Usuario, se ha creado Exitosamente El Perfil de Cargo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function show(JobPositionProfile $jobPositionProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(JobPositionProfile $jobPositionProfile)
    {
        return view('job_position_profile.edit', compact('jobPositionProfile'));
    }

    public function edit_formal_requirements(JobPositionProfile $jobPositionProfile)
    {
        $staffDecree = StaffDecree::latest()->first();

        $staffDecreeByEstaments = StaffDecreeByEstament::
            where('staff_decree_id', $staffDecree->id)
            ->where('estament_id', $jobPositionProfile->estament_id)
            ->get();

        foreach($staffDecreeByEstaments as $staffDecreeByEstament){
            if($jobPositionProfile->degree >= $staffDecreeByEstament->start_degree
                && $jobPositionProfile->degree <= $staffDecreeByEstament->end_degree){
                $generalRequirements = new StaffDecreeByEstament();
                $generalRequirements = $staffDecreeByEstament;
            }
        }

        return view('job_position_profile.edit_formal_requirements', compact('jobPositionProfile', 'generalRequirements'));
    }

    public function edit_objectives(JobPositionProfile $jobPositionProfile)
    {
        return view('job_position_profile.edit_objectives', compact('jobPositionProfile'));
    }

    public function edit_organization(JobPositionProfile $jobPositionProfile)
    {   
        return view('job_position_profile.edit_organization', compact('jobPositionProfile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPositionProfile $jobPositionProfile)
    {
        //
    }

    public function update_formal_requirements(Request $request, JobPositionProfile $jobPositionProfile, $generalRequirements)
    {
        $jobPositionProfile->staffDecreeByEstament()->associate($generalRequirements);
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();
        
        session()->flash('success', 'Estimado Usuario, se ha actualizado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.edit_formal_requirements', $jobPositionProfile);
    }

    public function update_objectives(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();

        //dd($request);
        if($request->descriptions){
            foreach ($request->descriptions as $key => $description) {
                $role = new Role();
                $role->description = $description;
                $role->jobPositionProfile()->associate($jobPositionProfile->id);
                $role->save();
            }
        }
        
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente los objetivos Perfil de Cargo');
        return redirect()->route('job_position_profile.edit_objectives', $jobPositionProfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPositionProfile $jobPositionProfile)
    {
        //
    }
}
