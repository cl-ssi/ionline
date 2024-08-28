<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\AssignEvaluation;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

use App\Models\Rrhh\Authority;
use Illuminate\Support\Facades\Mail;
use App\Mail\EndSelectionNotification;

use App\Models\Parameters\Parameter;

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
        if($requestReplacementStaff->assignEvaluations->count() > 0){
            $previous_assign = $requestReplacementStaff->assignEvaluations->last();
            $previous_assign->status = NULL;
            $previous_assign->save();

            $assign_evaluation = new AssignEvaluation($request->All());
            $assign_evaluation->user()->associate(auth()->user());
            $assign_evaluation->requestReplacementStaff()->associate($requestReplacementStaff);
            $assign_evaluation->status = 'assigned';
            $assign_evaluation->save();
        }
        else{
            $assign_evaluation = new AssignEvaluation($request->All());
            $assign_evaluation->user()->associate(auth()->user());
            $assign_evaluation->requestReplacementStaff()->associate($requestReplacementStaff);
            $assign_evaluation->status = 'assigned';
            $assign_evaluation->save();

            $technicalEvaluation = new TechnicalEvaluation();
            $technicalEvaluation->technical_evaluation_status = 'pending';
            $technicalEvaluation->user()->associate(auth()->user());
            $technicalEvaluation->organizational_unit_id = auth()->user()->organizationalUnit->id;
            $technicalEvaluation->request_replacement_staff_id = $requestReplacementStaff->id;
            $technicalEvaluation->save();
        }

        session()->flash('success', 'Se ha asignado exitosamente el Proceso de Selección');
        return redirect()->route('replacement_staff.request.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnicalEvaluation  $technicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(RequestReplacementStaff $requestReplacementStaff)
    {
        return view('replacement_staff.request.technical_evaluation.show',
            compact('requestReplacementStaff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TechnicalEvaluation  $technicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        $ouRoots = OrganizationalUnit::where('level', 1)->get();

        $users = User::where('external', 0)
          ->orderBy('name', 'ASC')
          ->get(['id', 'name', 'fathers_family', 'mothers_family']);

        $users_rys = User::where('organizational_unit_id', 48)->get();

        return view('replacement_staff.request.technical_evaluation.edit',
            compact('requestReplacementStaff', 'users', 'request', 'users_rys', 'ouRoots'));
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

    public function finalize_selection_process(Request $request, TechnicalEvaluation $technicalEvaluation)
    {
        // RECHAZO EVALUACION TECNICA
        $technicalEvaluation->technical_evaluation_status = 'rejected';
        $technicalEvaluation->date_end = Carbon::now();
        $technicalEvaluation->reason = $request->reason;
        $technicalEvaluation->observation = $request->observation;
        $technicalEvaluation->save();

        // RECHAZO SOLICITUD
        $technicalEvaluation->requestReplacementStaff->request_status = 'rejected';
        $technicalEvaluation->requestReplacementStaff->save();

        /* ELIMINAR APPROVALS DE FINANZAS
        $approval = $technicalEvaluation->requestReplacementStaff->approvals->last();
        if(str_contains($approval->subject, 'Certificado de disponibilidad presupuestaria')){
            $approval->delete();
        }
        */

        //REEMPLAZAR ENVÍO DE MAIL POR NOTIIFICACION
        $mail_request = $technicalEvaluation->requestReplacementStaff->user->email;
        $mail_notification_ou_manager = Authority::getAuthorityFromDate($technicalEvaluation->requestReplacementStaff->user->organizational_unit_id, Carbon::now(), 'manager');
        $ou_personal_manager = Authority::getAuthorityFromDate(Parameter::get('ou', 'PersonalSSI'), Carbon::now(), 'manager');

        if($ou_personal_manager){     
            $emails = [$mail_request,
                        $mail_notification_ou_manager->user->email,
                        $ou_personal_manager->user->email];
            Mail::to($emails)
            ->cc(env('APP_RYS_MAIL'))
            ->send(new EndSelectionNotification($technicalEvaluation));
        }

        return redirect()->route('replacement_staff.request.technical_evaluation.edit',['requestReplacementStaff' => $technicalEvaluation->requestReplacementStaff]);
    }

    public function create_document(RequestReplacementStaff $requestReplacementStaff){
        //dd($requestReplacementStaff);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('replacement_staff.request.documents.technical_evaluation_document', compact('requestReplacementStaff'));

        return $pdf->stream('mi-archivo.pdf');

        // $formDocumentFile = PDF::loadView('request_form.documents.form_document', compact('requestForm'));
        // return $formDocumentFile->download('pdf_file.pdf');
    }
}
