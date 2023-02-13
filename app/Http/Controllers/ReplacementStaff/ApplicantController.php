<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\Applicant;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Rrhh\Authority;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EndSelectionNotification;
use App\Notifications\ReplacementStaff\NotificationEndSelection;

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
              ->with('message-success-sirh-contract', 'Fecha de contrato correctamente ingresada para: '.$applicant->replacementStaff->FullName);
        }
        else{
            return redirect()
              ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff).'#applicant')
              ->with('message-success-evaluate-applicants', 'Calificación ingresada para: '.$applicant->replacementStaff->FullName);
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

    public function update_to_select(Request $request, Applicant $applicant)
    {
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

        /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
        $ou_personal_manager = Authority::getAuthorityFromDate(46, $now, 'manager');

        $emails = [$mail_request,
                    $mail_notification_ou_manager->user->email,
                    $ou_personal_manager->user->email];

        Mail::to($emails)
          ->cc(env('APP_RYS_MAIL'))
          ->send(new EndSelectionNotification($technicalEvaluation));

        //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
        /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
        $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, $now, 'manager');
        $notification_reclutamiento_manager->user->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'reclutamiento'));
        //SE NOTIFICA A USUARIO QUE CREA  
        $technicalEvaluation->requestReplacementStaff->user->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'user'));
        //SE NOTIFICA A USUARIO QUE SOLICITA
        if($technicalEvaluation->requestReplacementStaff->requesterUser){
            $technicalEvaluation->requestReplacementStaff->requesterUser->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'requester'));
        }
        //SE NOTIFICA A UNIDAD DE PERSONAL
        /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
        $notification_personal_manager = Authority::getAuthorityFromDate(46, $now, 'manager');
        $notification_personal_manager->user->notify(new NotificationEndSelection($technicalEvaluation->requestReplacementStaff, 'personal'));

        return redirect()
          ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff).'#applicant')
          ->with('message-success-aplicant-finish', 'Estimado usuario, ha completado el proceso de selección');
    }

    public function decline_selected_applicant(Request $request, Applicant $applicant){
        $applicant->fill($request->all());
        $applicant->desist = 1;

        $applicant->save();

        $applicantsSelected = Applicant::where('technical_evaluation_id', $applicant->technical_evaluation_id)
            ->where('selected', 1)
            ->where('desist', NULL)
            ->get();

        if($applicantsSelected->count() == 0){
            $applicant->technicalEvaluation->technical_evaluation_status = 'pending';
            $applicant->technicalEvaluation->date_end = NULL;
            $applicant->technicalEvaluation->save();

            $applicant->technicalEvaluation->requestReplacementStaff->request_status = 'pending';
            $applicant->technicalEvaluation->requestReplacementStaff->save();

            /* RR.HH. Nuevamente queda Disponible */
            $applicant->replacementStaff->status = 'immediate_availability';
            $applicant->replacementStaff->save();

            $applicant->technicalEvaluation->requestReplacementStaff->sirh_contract = NULL;
            $applicant->technicalEvaluation->requestReplacementStaff->save();
        }
        return redirect()
            ->to(route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation->requestReplacementStaff).'#applicant')
            ->with('message-danger-aplicant-desist', 'Estimado usuario, se ha registrado el postulante ha desestimado el proceso de selección');

    }
}
