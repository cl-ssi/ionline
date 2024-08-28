<?php

namespace App\Http\Controllers\JobPositionProfiles;

use App\Models\JobPositionProfiles\JobPositionProfile;
use App\Models\JobPositionProfiles\JobPositionProfileSign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parameters\Parameter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Rrhh\Authority;
use App\Notifications\JobPositionProfile\EndSigningProcess;
use App\Notifications\JobPositionProfile\Sign;
use App\Models\Documents\Approval;

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
        if((($jobPositionProfile->staff_decree_by_estament_id == NULL && $jobPositionProfile->contractual_condition_id != 2) && 
            $jobPositionProfile->general_requirement == NULL) ||
            ($jobPositionProfile->roles->count() <= 0 && $jobPositionProfile->objective == NULL) ||
            $jobPositionProfile->working_team == NULL ||
            $jobPositionProfile->jppLiabilities->count() <= 0 ||
            $jobPositionProfile->jppExpertises->count() <= 0){

            return redirect()->route('job_position_profile.edit_expertise_map', $jobPositionProfile);
        }
        else{
            /* SE CREAN APROBACIONES PARA LOS DEPTO. DEPENDIENTES */
            $organizationalUnit = $jobPositionProfile->organizationalUnit;
            $previousApprovalId = null;

            for ($i = $jobPositionProfile->organizationalUnit->level; $i >= 3; $i--){
                $approval = $jobPositionProfile->approvals()->create([
                    "module"                        => "Perfil de Cargos",
                    "module_icon"                   => "fas fa-id-badge fa-fw",
                    "subject"                       => "Solicitud de Aprobación Jefatura Depto. o Unidad",
                    "sent_to_ou_id"                 => $organizationalUnit->id,
                    "document_route_name"           => "job_position_profile.show_approval",
                    "document_route_params"         => json_encode(["job_position_profile_id" => $jobPositionProfile->id]),
                    "active"                        => ($previousApprovalId == null) ? true : false,
                    "previous_approval_id"          => $previousApprovalId,
                    "callback_controller_method"    => "App\Http\Controllers\JobPositionProfiles\JobPositionProfileSignController@approvalCallback",
                    "callback_controller_params"    => json_encode([
                        'job_position_profile_id' => $jobPositionProfile->id,
                        'process'                 => 'start'
                    ])
                ]);
                $previousApprovalId = $approval->id;

                if($organizationalUnit->level >= $i){
                    $organizationalUnit = $organizationalUnit->father;
                }
            }

            /* SE CREA APROBACIÓN DEPTO. GESTIÓN DEL TALENTO */
            $dgt_approval = $jobPositionProfile->approvals()->create([
                "module"                => "Perfil de Cargos",
                "module_icon"           => "fas fa-id-badge fa-fw",
                "subject"               => "Solicitud de Aprobación Depto. Gestión del Talento",
                "sent_to_ou_id"         => Parameter::get('ou','GestionDesarrolloDelTalento'),
                "document_route_name"   => "job_position_profile.show_approval",
                "document_route_params" => json_encode(["job_position_profile_id" => $jobPositionProfile->id]),
                "active"                => ($previousApprovalId == null) ? true : false,
                "previous_approval_id"  => $previousApprovalId,
                "callback_controller_method"    => "App\Http\Controllers\JobPositionProfiles\JobPositionProfileSignController@approvalCallback",
                "callback_controller_params"    => json_encode([
                    'job_position_profile_id' => $jobPositionProfile->id,
                    'process'                 => "dgt"
                ])
            ]);

            /* AGREGO SUBDIRECCIONES EN ARRAY */
            $sdr_approval = null;
            if($organizationalUnit->id != Parameter::get('ou','SubRRHH')){
                /* SE CREA APROBACIÓN PARA S.D. AREA REQUIRENTE (EXCEPTO SDGP) */
                $sdr_approval = $jobPositionProfile->approvals()->create([
                    "module"                => "Perfil de Cargos",
                    "module_icon"           => "fas fa-id-badge fa-fw",
                    "subject"               => "Solicitud de Aprobación Subdirección O Depto.",
                    "sent_to_ou_id"         => $organizationalUnit->id,
                    "document_route_name"   => "job_position_profile.show_approval",
                    "document_route_params" => json_encode(["job_position_profile_id" => $jobPositionProfile->id]),
                    "active"                => false,
                    "previous_approval_id"  => $dgt_approval->id,
                    "callback_controller_method"    => "App\Http\Controllers\JobPositionProfiles\JobPositionProfileSignController@approvalCallback",
                    "callback_controller_params"    => json_encode([
                        'job_position_profile_id' => $jobPositionProfile->id,
                        'process'                 => null
                    ])
                ]);
            }

            /* SE CREA APROBACIÓN PARA S.D.G.P. */
            $sdrgp_approval = $jobPositionProfile->approvals()->create([
                "module"                => "Perfil de Cargos",
                "module_icon"           => "fas fa-id-badge fa-fw",
                "subject"               => "Solicitud de Aprobación Subdirección G.P.",
                "sent_to_ou_id"         => Parameter::get('ou','SubRRHH'),
                "document_route_name"   => "job_position_profile.show_approval",
                "document_route_params" => json_encode(["job_position_profile_id" => $jobPositionProfile->id]),
                "active"                => false,
                "previous_approval_id"  => ($sdr_approval != null) ? $sdr_approval->id : $dgt_approval->id, 
                "callback_controller_method"    => "App\Http\Controllers\JobPositionProfiles\JobPositionProfileSignController@approvalCallback",
                "callback_controller_params"    => json_encode([
                    'job_position_profile_id' => $jobPositionProfile->id,
                    'process'                 => 'end'
                ])
            ]);
        }    
        
        if($jobPositionProfile->approvals->first()->sent_to_ou_id == Parameter::get('ou','GestionDesarrolloDelTalento')){
            $jobPositionProfile->status = 'review';
        }
        else{
            $jobPositionProfile->status = 'sent';
        }
        
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
            $jobPositionProfileSign->user_id = auth()->id();
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

                /* SE NOTIFICACA A LA UNIDAD ORGANIZACIONAL PARA CONTINUAR EL PROCESO DE FIRMAS */
                $notification_ou_manager = Authority::getAuthorityFromDate($nextSign->organizational_unit_id, today(), 'manager');
                if($notification_ou_manager){
                    $notification_ou_manager->user->notify(new Sign($jobPositionProfile));
                }

                session()->flash('success', 'Estimado Usuario: El Perfil de Cargo ha sido Aprobado con exito.');
                return redirect()->route('job_position_profile.index_to_sign');
            }
            else{
                $jobPositionProfile->status = 'complete';
                $jobPositionProfile->save();
                
                /* 
                AQUÍ IMPLEMENTAR NOTIFICACIONES
                */

                /* SE NOTIFICACA AL DEPTO. DESARROLLO Y GESTION DEL TALENTO PARA INFORMANDO EL FIN DE PROCESO DE FIRMAS */
                $notification_ou_manager = Authority::getAuthorityFromDate(Parameter::where('module', 'ou')->where('parameter', 'GestionDesarrolloDelTalento')->first()->value, today(), 'manager');
                if($notification_ou_manager){
                    $notification_ou_manager->user->notify(new EndSigningProcess($jobPositionProfile));
                }
                
                session()->flash('success', 'Estimado Usuario: El Perfil de Cargo ha sido Aprobado con exito.');
                return redirect()->route('job_position_profile.index_to_sign');
            }
        }
        else{
            $jobPositionProfileSign->user_id        = auth()->id();
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

    /**
     * Función callback para aprobaciones 
     */
    public function approvalCallback($approval_id, $job_position_profile_id, $process){
        $approval = Approval::find($approval_id);
        $jobPositionProfile = JobPositionProfile::find($job_position_profile_id);
        
        /* Aprueba */
        if($approval->status == 1){
            if($process == 'start'){
                $jobPositionProfile->status = 'review';
                $jobPositionProfile->save();
            }
            if($process == 'dgt'){
                $jobPositionProfile->status = 'pending';
                $jobPositionProfile->save();
            }
            if($process == 'end'){
                $jobPositionProfile->status = 'complete';
                $jobPositionProfile->save();
            }
        }   

        /* Rechaza */
        if($approval->status == 0){
            $jobPositionProfile->status = 'rejected';
            $jobPositionProfile->save();

        }
    }
}
