<?php

namespace App\Http\Controllers\JobPositionProfiles;

use App\Models\JobPositionProfiles\JobPositionProfile;
use App\Models\JobPositionProfiles\JobPositionProfileSign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parameters\Parameter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if(($jobPositionProfile->staff_decree_by_estament_id == NULL && $jobPositionProfile->general_requirement == NULL) ||
            ($jobPositionProfile->roles->count() <= 0 && $jobPositionProfile->objective == NULL) ||
            $jobPositionProfile->working_team == NULL ||
            $jobPositionProfile->jppLiabilities->count() <= 0 ||
            $jobPositionProfile->jppExpertises->count() <= 0){

            return redirect()->route('job_position_profile.edit_expertise_map', $jobPositionProfile);
        }
        else{
            $position = 1;
            for ($i = $jobPositionProfile->organizationalUnit->level; $i >= 2; $i--) {
                //SI LA U.O. SOLICITANTE ES MAYOR A NIVEL 2 
                if ($i > 2) {
                    $jpp_sing                           = new JobPositionProfileSign();
                    $jpp_sing->position                 = $position;
                    $jpp_sing->event_type               = 'leadership';
                    if($i == $jobPositionProfile->organizationalUnit->level){
                        $jpp_sing->organizational_unit_id   = $jobPositionProfile->organizationalUnit->id;
                        $jpp_sing->status = 'pending';
                    }
                    else{
                        $lastSign = JobPositionProfileSign::
                            where('job_position_profile_id', $jobPositionProfile->id)
                            ->latest()
                            ->first();

                        $jpp_sing->organizational_unit_id   = $lastSign->organizationalUnit->father->id;
                    }

                    $jpp_sing->job_position_profile_id = $jobPositionProfile->id;
                    $jpp_sing->save();
                }
                if ($i == 2) {
                    //SI LA PRIMERA POSICIÓN ES LA U.O SOLICITANTE
                    if($position == 1){
                        $jpp_sing                               = new JobPositionProfileSign();
                        $jpp_sing->position                     = $position;
                        $jpp_sing->event_type                   = 'leadership';
                        $jpp_sing->organizational_unit_id       = $jobPositionProfile->organizationalUnit->id;
                        $jpp_sing->status                       = 'pending';
                        $jpp_sing->job_position_profile_id      = $jobPositionProfile->id;
                        $jpp_sing->save();

                        $position++;
                    }
                    // U.O. GESTIÓN DEL TALENTO
                    $jpp_review = new JobPositionProfileSign();
                    $jpp_review->position = $position;
                    $jpp_review->event_type = 'review';
                    $jpp_review->organizational_unit_id = Parameter::where('module', 'ou')->where('parameter', 'GestionDesarrolloDelTalento')->first()->value;
                    $jpp_review->job_position_profile_id = $jobPositionProfile->id;
                    $jpp_review->save();

                    $lastSign = JobPositionProfileSign::
                        where('job_position_profile_id', $jobPositionProfile->id)
                        ->where('event_type', 'leadership')
                        ->orderBy('position', 'DESC')
                        ->first();

                    if($lastSign->organizationalUnit->father->level > 1){
                        $jpp_esign = new JobPositionProfileSign();
                        $jpp_esign->position = $position + 1;
                        $jpp_esign->event_type = 'subdir o depto';
                        $jpp_esign->organizational_unit_id   = $lastSign->organizationalUnit->father->id;
                        $jpp_esign->job_position_profile_id = $jobPositionProfile->id;
                        $jpp_esign->save();
                    }
                }
                $position++;
            }
            //SI LA PRIMERA POSICIÓN ES LA U.O SOLICITANTE, SE AGREGA AL FINAL SUB. RRHH.
            if($jobPositionProfile->organizationalUnit->level == 2){
                $jpp_subrrhh = new JobPositionProfileSign();
                $jpp_subrrhh->position = $position;
                $jpp_subrrhh->event_type = 'subrrhh';
                $jpp_subrrhh->organizational_unit_id = Parameter::where('module', 'ou')->where('parameter', 'SubRRHH')->first()->value;
                $jpp_subrrhh->job_position_profile_id = $jobPositionProfile->id;
                $jpp_subrrhh->save();
            }
        }
        
        $jobPositionProfile->status = 'sent';
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
    public function update(Request $request, JobPositionProfileSign $jobPositionProfileSign, $status, JobPositionProfile $jobPositionProfile)
    {
        if($status == 'accepted'){
            $jobPositionProfileSign->user_id = Auth::user()->id;
            $jobPositionProfileSign->status = $status;
            $jobPositionProfileSign->date_sign = now();
            $jobPositionProfileSign->save();

            $nextSign = $jobPositionProfile->jobPositionProfileSigns->where('position', $jobPositionProfileSign->position + 1)->first();
            
            if($nextSign){
                $nextSign->status = 'pending';
                $nextSign->save();
                
                if($nextSign->event_type == 'review'){
                    $jobPositionProfile->status = 'review';
                    $jobPositionProfile->save();
                }
                if($nextSign->event_type == 'subdir o depto' || $nextSign->event_type == 'subrrhh'){
                    $jobPositionProfile->status = 'pending';
                    $jobPositionProfile->save();
                }

                /* 
                AQUÍ IMPLEMENTAR NOTIFICACIONES
                */

                session()->flash('success', 'Estimado Usuario: El Perfil de Cargo ha sido Aprobado con exito.');
                return redirect()->route('job_position_profile.index_to_sign');
            }
            else{
                $jobPositionProfile->status = 'complete';
                $jobPositionProfile->save();
                
                /* 
                AQUÍ IMPLEMENTAR NOTIFICACIONES
                */
                
                session()->flash('success', 'Su solicitud ha sido Aceptada en su totalidad.');
                return redirect()->route('replacement_staff.request.to_sign');
            }
        }
        else{
            $jobPositionProfileSign->user_id        = Auth::user()->id;
            $jobPositionProfileSign->status         = $status;
            $jobPositionProfileSign->observation    = $request->observation;
            $jobPositionProfileSign->date_sign      = now();
            $jobPositionProfileSign->save();

            $jobPositionProfile->status = 'rejected';
            $jobPositionProfile->save();

            //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
            //Aquí

            session()->flash('danger', 'Su solicitud ha sido Rechazada con éxito.');
            return redirect()->route('job_position_profile.index_to_sign');
        }
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
