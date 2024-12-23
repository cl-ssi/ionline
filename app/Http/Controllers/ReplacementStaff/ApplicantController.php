<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\Applicant;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\Rrhh\Authority;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EndSelectionNotification;
use App\Notifications\ReplacementStaff\NotificationEndSelection;
use App\Models\Parameters\Parameter;
use App\Models\Documents\Approval;
use Illuminate\Support\Facades\Storage;

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
        if ($request->missing('replacement_staff_id')) {
            return redirect()
              ->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation->requestReplacementStaff).'#applicant')
              ->with('message-danger-without-applicants', 'Estimado usuario, primero debe seleccionar postulante(s) al cargo');
        }
        else{
            foreach ($request->replacement_staff_id as $key_file => $req) {
                $exist = Applicant::where('replacement_staff_id', $req)
                    ->Where('technical_evaluation_id', $technicalEvaluation->id)
                    ->get();

                if($exist->isEmpty()){
                    $applicant = new Applicant();
                    $applicant->replacement_staff_id = $req;
                    $applicant->psycholabor_evaluation_score = 80;
                    $applicant->technical_evaluation_score = 80;
                    $applicant->observations = 'Integrante de Staff';
                    $applicant->technicalEvaluation()->associate($technicalEvaluation);
                    $applicant->save();
                }
            }
            return redirect()
                ->to(route('replacement_staff.request.technical_evaluation.edit', $technicalEvaluation->requestReplacementStaff).'#applicant')
                ->with('message-success-applicants', 'El postulante ha sido correctamente ingresado/s.');
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
        $applicant->fill($request->all());
        $applicant->save();

        if($request->has('sirh_contract')){
            $applicant->technicalEvaluation->requestReplacementStaff->sirh_contract = 1;
            $applicant->technicalEvaluation->requestReplacementStaff->save();

            return redirect()
              ->to(route('replacement_staff.request.technical_evaluation.show', $applicant->technicalEvaluation->requestReplacementStaff).'#applicant')
              ->with('message-success-sirh-contract', 'Fecha de contrato correctamente ingresada para: '.$applicant->replacementStaff->fullName);
        }
        else{
            return redirect()
              ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff).'#applicant')
              ->with('message-success-evaluate-applicants', 'Calificación ingresada para: '.$applicant->replacementStaff->fullName);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        $applicant->delete();

        return redirect()
          ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technical_evaluation_id).'#applicant')
          ->with('message-danger-delete-applicants', 'Estimado usuario, primero debe seleccionar postulante(s) al cargo');
    }

    public function update_to_select(Request $request)
    {
        $applicant_evaluated = Applicant::find($request->applicant_id);

        if($applicant_evaluated->psycholabor_evaluation_score == 0 || $applicant_evaluated->technical_evaluation_score == 0){
            return redirect()
                ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant_evaluated->technicalEvaluation->requestReplacementStaff).'#applicant')
                ->with('message-danger-aplicant-no-evaluated', 'Estimado usuario, favor ingresar evaluacion de postulante(s) seleccionado(s).');
        }
        else{
            // SE MARCA EL POSTULANTE COMO SELECCIONADO
            $applicant_evaluated->fill($request->all());
            $applicant_evaluated->selected = 1;
            $applicant_evaluated->save();

            // SE CAMBIA EL ESTADO DEL INTEGRANTE DEL STAFF: "SELECCIONADO"
            //$applicant_evaluated->replacementStaff->status = 'selected';
            //PETICIÓN DE NO CAMBIAR ESTADO A SELECCIONADO: TODOS DISPONIBLES
            $applicant_evaluated->replacementStaff->save();

            // SE CAMBIA EL ESTADO DE LA EVALUACION TECNICA
            $applicant_evaluated->technicalEvaluation->date_end = now();
            $applicant_evaluated->technicalEvaluation->technical_evaluation_status = 'complete';
            $applicant_evaluated->technicalEvaluation->save();

            // SE CAMBIA EL ESTADO DE LA SOLICITUD: "FINANCE SIGN"
            $applicant_evaluated->technicalEvaluation->requestReplacementStaff->request_status = 'finance sign';
            $applicant_evaluated->technicalEvaluation->requestReplacementStaff->save();

            /*
            // SE CREA APPROVAL DE F.E. FINANZAS
            $approval = $applicant_evaluated->technicalEvaluation->requestReplacementStaff->approvals()->create([
                "module"                            => "Solicitudes de Contración",
                "module_icon"                       => "bi bi-id-card",
                "subject"                           => 'Certificado de disponibilidad presupuestaria<br><br>
                                                        ID: '. $applicant_evaluated->technicalEvaluation->requestReplacementStaff->id.'<br><br>'.
                                                        '<small><b>Periodo</b>: '. $applicant_evaluated->start_date->format('d-m-Y').' - '.$applicant_evaluated->end_date->format('d-m-Y').'<br>'.
                                                        '<b>Funcionario</b>: '. $applicant_evaluated->replacementStaff->fullName.'<br>'.
                                                        '<b> Codigo Item Presupuestario </b> - Nombre Item Presupuestario </small>',
                "sent_to_ou_id"                     => Parameter::get('ou','FinanzasSSI'),
                "document_route_name"               => "replacement_staff.request.create_budget_availability_certificate_approval_view",
                "document_route_params"             => json_encode(["request_replacement_staff_id" => $applicant_evaluated->technicalEvaluation->requestReplacementStaff->id]),
                "digital_signature"                 => true,
                "active"                            => true,
                "previous_approval_id"              => $applicant_evaluated->technicalEvaluation->requestReplacementStaff->approvals->last()->id,
                "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                "callback_controller_params"        => json_encode([
                    'request_replacement_staff_id'  => $applicant_evaluated->technicalEvaluation->requestReplacementStaff->id,
                    'process'                       => null
                ])
            ]);
            */

            // APPROVAL DE FINANZAS
            $approval = $applicant_evaluated->technicalEvaluation->requestReplacementStaff->approvals()->create([
                "module"                            => "Solicitudes de Contración",
                "module_icon"                       => "bi bi-id-card",
                "subject"                           => 'Certificado de disponibilidad presupuestaria<br><br>
                                                            ID: '. $applicant_evaluated->technicalEvaluation->requestReplacementStaff->id.'<br><br>'.
                                                            '<small><b>Periodo</b>: '. $applicant_evaluated->start_date->format('d-m-Y').' - '.$applicant_evaluated->end_date->format('d-m-Y').'<br>'.
                                                            '<b>Funcionario</b>: '. $applicant_evaluated->replacementStaff->fullName.'<br>'.
                                                            '<b>'.$applicant_evaluated->technicalEvaluation->requestReplacementStaff->budgetItem->code.'</b> - '.$applicant_evaluated->technicalEvaluation->requestReplacementStaff->budgetItem->name.'</small>',
                "sent_to_ou_id"                     => ($applicant_evaluated->technicalEvaluation->requestReplacementStaff->establishment_id == Parameter::get('establishment','SSTarapaca')) ? Parameter::get('ou','FinanzasSSI') : (($applicant_evaluated->technicalEvaluation->requestReplacementStaff->establishment_id == Parameter::get('establishment','HospitalAltoHospicio')) ? Parameter::get('ou','FinanzasHAH') : ''),
                "document_route_name"               => "replacement_staff.request.show_new_budget_availability_certificate_pdf",
                "document_route_params"             => json_encode([
                    "request_replacement_staff_id" => $applicant_evaluated->technicalEvaluation->requestReplacementStaff->id
                ]),
                "document_pdf_path"                 => null,
                "active"                            => true,
                "previous_approval_id"              => $applicant_evaluated->technicalEvaluation->requestReplacementStaff->approvals->last()->id,
                "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                "callback_controller_params"        => json_encode([
                    'request_replacement_staff_id'  => $applicant_evaluated->technicalEvaluation->requestReplacementStaff->id,
                    'applicant_id'                  => $applicant_evaluated->id,
                    'process'                       => 'end'
                ]),
                "digital_signature"                 => true,
                "position"                          => "right",
                "filename"                          => "ionline/replacement_staff/budget_availability_certificate/".$applicant_evaluated->technicalEvaluation->requestReplacementStaff->id."_".$applicant_evaluated->id.".pdf"
            ]);
        }

        $notification_reclutamiento_manager = Authority::getAuthorityFromDate(Parameter::where('module', 'ou')->where('parameter', 'Reclutamiento', $applicant_evaluated->technicalEvaluation->requestReplacementStaff->establishment_id)->first()->value, today(), 'manager');
        if($notification_reclutamiento_manager){
            $notification_reclutamiento_manager->user->notify(new NotificationEndSelection($applicant_evaluated->technicalEvaluation->requestReplacementStaff, 'reclutamiento'));
        }
        //SE NOTIFICA A USUARIO QUE CREA  
        $applicant_evaluated->technicalEvaluation->requestReplacementStaff->user->notify(new NotificationEndSelection($applicant_evaluated->technicalEvaluation->requestReplacementStaff, 'user'));
        //SE NOTIFICA A USUARIO QUE SOLICITA
        if($applicant_evaluated->technicalEvaluation->requestReplacementStaff->requesterUser){
            $applicant_evaluated->technicalEvaluation->requestReplacementStaff->requesterUser->notify(new NotificationEndSelection($applicant_evaluated->technicalEvaluation->requestReplacementStaff, 'requester'));
        }

        /*        
        foreach ($request->applicant_id as $key_file => $app_id) {
            $applicant_evaluated = Applicant::where('id', $app_id)->first();
            if($applicant_evaluated->psycholabor_evaluation_score == 0 || $applicant_evaluated->technical_evaluation_score == 0){
                return redirect()
                  ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff).'#applicant')
                  ->with('message-danger-aplicant-no-evaluated', 'Estimado usuario, favor ingresar evaluacion de postulante(s) seleccionado(s).');
            }
        }

        foreach ($request->applicant_id as $app_id) {
            $applicant_evaluated = Applicant::where('id', $app_id)->first();

            $applicant_evaluated->fill($request->all());
            $applicant_evaluated->selected = 1;

            $applicant_evaluated->replacementStaff->status = 'selected';
            $applicant_evaluated->replacementStaff->save();

            $applicant_evaluated->save();
        }

        $technicalEvaluation = TechnicalEvaluation::
          where('id', $applicant_evaluated->technical_evaluation_id)
          ->first();

        $now = Carbon::now();
        $technicalEvaluation->date_end = $now;
        $technicalEvaluation->technical_evaluation_status = 'complete';
        $technicalEvaluation->save();

        $technicalEvaluation->requestReplacementStaff->request_status = 'complete';
        $technicalEvaluation->requestReplacementStaff->save();
        
        
        //NOTIFICACIÓN VÍA CORREO ELECTRONICO
        $mail_request = $technicalEvaluation->requestReplacementStaff->user->email;
        //Manager
        $type = 'manager';
        $mail_notification_ou_manager = Authority::getAuthorityFromDate($technicalEvaluation->requestReplacementStaff->user->organizational_unit_id, $now, $type);

        //  FIX: @mirandaljorge si no hay manager en Authority, se va a caer 
        $ou_personal_manager = Authority::getAuthorityFromDate(46, $now, 'manager');

        $emails = [$mail_request,
                    $mail_notification_ou_manager->user->email,
                    $ou_personal_manager->user->email];

        Mail::to($emails)
          ->cc(env('APP_RYS_MAIL'))
          ->send(new EndSelectionNotification($technicalEvaluation));

        // NOTIFICACION PARA RECLUTAMIENTO
        $notification_reclutamiento_manager = Authority::getAuthorityFromDate(Parameter::where('module', 'ou')->where('parameter', 'ReclutamientoSSI')->first()->value, today(), 'manager');
        if($notification_reclutamiento_manager){
            $notification_reclutamiento_manager->user->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'reclutamiento'));
        }
        //SE NOTIFICA A USUARIO QUE CREA  
        $technicalEvaluation->requestReplacementStaff->user->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'user'));
        //SE NOTIFICA A USUARIO QUE SOLICITA
        if($technicalEvaluation->requestReplacementStaff->requesterUser){
            $technicalEvaluation->requestReplacementStaff->requesterUser->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'requester'));
        }
        //SE NOTIFICA A UNIDAD DE PERSONAL
        // FIX: @mirandaljorge si no hay manager en Authority, se va a caer 
        $notification_personal_manager = Authority::getAuthorityFromDate(46, $now, 'manager');
        $notification_personal_manager->user->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'personal'));
        */
        return redirect()
          ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant_evaluated->technicalEvaluation->requestReplacementStaff).'#applicant')
          ->with('message-success-aplicant-finish', 'Estimado usuario, ha completado el proceso de selección');
    }

    public function decline_selected_applicant(Request $request, Applicant $applicant){
        //POSTULANTE DESISTE
        $applicant->fill($request->all());
        $applicant->desist = 1;
        $applicant->save();

        $applicantsSelected = Applicant::where('technical_evaluation_id', $applicant->technical_evaluation_id)
            ->where('selected', 1)
            ->where('desist', NULL)
            ->get();

        if($applicantsSelected->count() == 0){
            //SE CAMBIA ESTADO DE E.T. A PENDIENTE
            $applicant->technicalEvaluation->technical_evaluation_status = 'pending';
            $applicant->technicalEvaluation->date_end = NULL;
            $applicant->technicalEvaluation->save();

            //SE CAMBIA ESTADO DE SOLICITUD A PENDIENTE
            $applicant->technicalEvaluation->requestReplacementStaff->request_status = 'pending';
            $applicant->technicalEvaluation->requestReplacementStaff->save();

            // RR.HH. DISPONIBLE
            $applicant->replacementStaff->status = 'immediate_availability';
            $applicant->replacementStaff->save();

            //SE ELIMINA CONTRATO EN SIRH
            $applicant->technicalEvaluation->requestReplacementStaff->sirh_contract = NULL;
            $applicant->technicalEvaluation->requestReplacementStaff->save();

            // ELIMINAR APPROVALS DE FINANZAS
            if($request->reason == 'rechazo oferta laboral' || $request->reason == 'error digitacion'){
                $approval = $applicant->technicalEvaluation->requestReplacementStaff->approvals->last();
                if(str_contains($approval->subject, 'Certificado de disponibilidad presupuestaria') &&
                    $approval->status == NULL){
                    $approval->delete();
                }
            }
        }
        return redirect()
            ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff).'#applicant')
            ->with('message-danger-aplicant-desist', 'Estimado usuario, se ha registrado el postulante ha desestimado el proceso de selección');

    }

    public function download_budget_availavility_certificate_pdf(Applicant $applicant)
    {
        $approval = Approval::find($applicant->approval_id);

        if( Storage::exists($approval->filename) ) {
            return Storage::response($approval->filename);
        } 
        else {
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado.');
        }
    }
}
