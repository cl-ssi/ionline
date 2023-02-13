<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\RequestSign;
use App\Models\ReplacementStaff\AssignEvaluation;
use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
// use App\Mail\NewRequestReplacementStaff;
// use App\Mail\NotificationSign;
use App\Notifications\ReplacementStaff\NotificationSign;
use App\Notifications\ReplacementStaff\NotificationNewRequest;
use Illuminate\Support\Facades\Storage;


class RequestReplacementStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('replacement_staff.request.index');
    }

    public function assign_index()
    {
        $pending_requests = RequestReplacementStaff::latest()
            ->WhereHas('technicalEvaluation', function($q) {
              $q->Where('technical_evaluation_status', 'pending');
            })
            ->WhereHas('assignEvaluations', function($j) {
              $j->Where('to_user_id', Auth::user()->id)
               ->where('status', 'assigned');
            })
            ->get();

        $requests = RequestReplacementStaff::latest()
            ->WhereHas('technicalEvaluation', function($q) {
              $q->Where('technical_evaluation_status', 'complete')
              ->OrWhere('technical_evaluation_status', 'rejected');
            })
            ->WhereHas('assignEvaluations', function($j) {
              $j->Where('to_user_id', Auth::user()->id)
               ->where('status', 'assigned');
            })
            ->paginate(10);

        return view('replacement_staff.request.assign_index', compact('pending_requests', 'requests'));
    }

    public function own_index()
    {
        $my_pending_requests = RequestReplacementStaff::latest()
            ->where('user_id', Auth::user()->id)
            ->where('request_status', 'pending')
            ->get();

        $my_request = RequestReplacementStaff::latest()
            ->where('user_id', Auth::user()->id)
            ->where(function ($q){
              $q->where('request_status', 'complete')
                ->orWhere('request_status', 'rejected');
            })
            ->paginate(10);

        return view('replacement_staff.request.own_index', compact('my_request', 'my_pending_requests'));
    }

    public function personal_index()
    {
        // $my_pending_requests = RequestReplacementStaff::latest()
        //     ->where('user_id', Auth::user()->id)
        //     ->where('request_status', 'pending')
        //     ->get();

        $requests = RequestReplacementStaff::latest()
            //->where('user_id', Auth::user()->id)
            ->where(function ($q){
              $q->where('request_status', 'complete')
                ->orWhere('request_status', 'rejected');
            })
            ->paginate(15);

        //dd($requests);

        return view('replacement_staff.request.personal_index', compact('requests'));
    }

    public function pending_personal_index()
    {
        $requests = RequestReplacementStaff::latest()
            ->where('request_status', 'pending')
            ->paginate(15);

        return view('replacement_staff.request.pending_personal_index', compact('requests'));
    }

    public function ou_index()
    {
        $ou_pending_requests = RequestReplacementStaff::latest()
            ->where(function ($q){
              $q->where('user_id', Auth::user()->id)
                ->orWhere('organizational_unit_id', Auth::user()->organizationalUnit->id);
            })
            ->where('request_status', 'pending')
            ->get();

        $ou_requests = RequestReplacementStaff::latest()
            ->where(function ($q){
              $q->where('user_id', Auth::user()->id)
                ->orWhere('organizational_unit_id', Auth::user()->organizationalUnit->id);
            })
            ->where(function ($q){
              $q->where('request_status', 'complete')
                ->orWhere('request_status', 'rejected');
            })
            ->paginate(10);

        return view('replacement_staff.request.ou_index', compact('ou_pending_requests', 'ou_requests'));
    }

    public function to_sign(RequestReplacementStaff $requestReplacementStaff)
    {
        $date = Carbon::now();
        $type = 'manager';
        $user_id = Auth::user()->id;

        $authorities = Authority::getAmIAuthorityFromOu(today(), $type, $user_id);

        foreach ($authorities as $authority){
            $iam_authorities_in[] = $authority->organizational_unit_id;
        }

        if($authorities->isNotEmpty()){
            $pending_requests_to_sign = RequestReplacementStaff::latest()
                ->whereHas('requestSign', function($q) use ($authority, $iam_authorities_in){
                    $q->Where('organizational_unit_id', $iam_authorities_in)
                    ->Where('request_status', 'pending');
                })
                ->get();

            $requests_to_sign = RequestReplacementStaff::latest()
                ->whereHas('requestSign', function($q) use ($authority, $iam_authorities_in){
                    $q->Where('organizational_unit_id', $iam_authorities_in)
                    ->Where(function ($j){
                        $j->Where('request_status', 'accepted')
                        ->OrWhere('request_status', 'rejected');
                    });
                })
                ->paginate(10);
            return view('replacement_staff.request.to_sign', compact('pending_requests_to_sign', 'requests_to_sign'));
        }
        else{
            $pending_requests_to_sign = RequestReplacementStaff::latest()
                ->whereHas('requestSign', function($q) {
                    $q->Where('organizational_unit_id', 46)
                    ->Where('request_status', 'pending');
                })
                ->get();

            $requests_to_sign = RequestReplacementStaff::latest()
                ->whereHas('requestSign', function($q) {
                    $q->Where('organizational_unit_id', 46)
                    ->Where(function ($j){
                        $j->Where('request_status', 'accepted')
                        ->OrWhere('request_status', 'rejected');
                    });
                })
                ->paginate(10);
            return view('replacement_staff.request.to_sign', compact('pending_requests_to_sign', 'requests_to_sign'));
        }

        session()->flash('danger', 'Estimado Usuario/a: Usted no dispone de solicitudes para aprobación.');
        return redirect()->route('replacement_staff.request.own_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('replacement_staff.request.create');
    }

    public function create_replacement()
    {
        return view('replacement_staff.request.create_replacement');
    }

    public function create_announcement()
    {
        return view('replacement_staff.request.create_announcement');
    }

    public function create_extension(RequestReplacementStaff $requestReplacementStaff)
    {
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        return view('replacement_staff.request.create_extension', compact('requestReplacementStaff', 'ouRoots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $formType)
    {
        if(Auth::user()->organizationalUnit->level == 3){
            /* SE OBTIENEN LA INFORMACIÓN DEL FORMULARIO */
            $request_replacement = new RequestReplacementStaff($request->All());
            $request_replacement->form_type = $formType;
            $request_replacement->user()->associate(Auth::user());
            $request_replacement->organizational_unit_id = Auth::user()->organizationalUnit->id;
            $request_replacement->requesterUser()->associate($request->requester_id);

            /* CONDICIÓN DE CONVOCATORIA INTERNA O MIXTA */
            if($request->fundament_detail_manage_id != 6 && $request->fundament_detail_manage_id != 7){
                $request_replacement->request_status = 'pending';
            }
            else{
                $request_replacement->request_status = 'complete';
            }

            $now = Carbon::now()->format('Y_m_d_H_i_s');
            if($request->hasFile('job_profile_file')){
                $file = $request->file('job_profile_file');
                $file_name = $now.'_job_profile';
                $request_replacement->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
            }

            $file_verification = $request->file('request_verification_file');
            $file_name_verification = $now.'_request_verification';
            $request_replacement->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');

            $request_replacement->save();

            /* SE CONSULTA UO DEL USUARIO QUE REGISTRA */
            $uo_request = OrganizationalUnit::where('id', $request_replacement->organizational_unit_id)
                ->get()
                ->last();
            
            if($request_replacement->form_type == 'replacement'){
                //UO Nivel 3 Deptos. bajo SUB Direcciones.
                if($uo_request->level == 3){
                    for ($i = 1; $i <= 4; $i++) {
                        $request_sing = new RequestSign();

                        $date = Carbon::now()->format('Y_m_d_H_i_s');
                        $type = 'manager';
                        $type_adm = 'secretary';
                        $user_id = Auth::user()->id;

                        $iam_authority = Authority::getAmIAuthorityFromOu(today(), $type, $user_id);

                        if($iam_authority->isNotEmpty()){
                            if($i == 1){
                                $request_sing->position = '1';
                                $request_sing->ou_alias = 'leadership';
                                $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                                $request_sing->user_id = $user_id;
                                $request_sing->request_status = 'accepted';
                                $request_sing->date_sign = Carbon::now();
                            }
                            if ($i == 2) {
                                $request_sing->position = '2';
                                $request_sing->ou_alias = 'sub';
                                $request_sing->organizational_unit_id = $uo_request->father->id;
                                $request_sing->request_status = 'pending';
                                
                                // AQUI ENVIAR NOTIFICACIÓN DE CORREO ELECTRONICO AL NUEVO VISADOR.

                                //manager
                                $type = 'manager';
                                /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
                                $mail_notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, Carbon::now(), $type);
                                //secretary
                                $type_adm = 'secretary';
                                $mail_notification_ou_secretary = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, Carbon::now(), $type_adm);

                                $emails = [$mail_notification_ou_manager->user->email, $mail_notification_ou_secretary->user->email];

                            //   Mail::to($emails)
                            //     ->cc(env('APP_RYS_MAIL'))
                            //     ->send(new NotificationSign($request_replacement));
                            }

                            if ($i == 3) {
                                $request_sing->position = '3';
                                $request_sing->ou_alias = 'uni_per';
                                $request_sing->organizational_unit_id = 46;
                            }

                            if ($i == 4) {
                                $request_sing->position = '4';
                                $request_sing->ou_alias = 'sub_rrhh';
                                $request_sing->organizational_unit_id = 44;
                            }
                        }
                        else{
                            if($i == 1){
                                $request_sing->position = '1';
                                $request_sing->ou_alias = 'leadership';
                                $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                                $request_sing->request_status = 'pending';

                                //SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS
                                /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
                                $notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type);
                                $notification_ou_manager->user->notify(new NotificationSign($request_replacement));
                            }
                            if ($i == 2) {
                            $request_sing->position = '2';
                            $request_sing->ou_alias = 'sub';
                            $request_sing->organizational_unit_id = $uo_request->father->id;
                            }
                            if ($i == 3) {
                                $request_sing->position = '3';
                                $request_sing->ou_alias = 'uni_per';
                                $request_sing->organizational_unit_id = 46;
                            }
                            if ($i == 4) {
                                $request_sing->position = '4';
                                $request_sing->ou_alias = 'sub_rrhh';
                                $request_sing->organizational_unit_id = 44;
                            }
                        }
                        $request_sing->request_replacement_staff_id = $request_replacement->id;
                        $request_sing->save();
                    }
                }
            }

            //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
            /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
            $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, Carbon::now(), 'manager');
            $notification_reclutamiento_manager->user->notify(new NotificationNewRequest($request_replacement, 'reclutamiento'));
            $request_replacement->requesterUser->notify(new NotificationNewRequest($request_replacement, 'requester'));

            session()->flash('success', 'Estimados Usuario, se ha creado la Solicitud Exitosamente');
            return redirect()->route('replacement_staff.request.own_index');
        }
        else{
            session()->flash('danger', 'Estimado Usuario, su unidad organizacional no está autorizada para generar solicitudes, favor contactar a la Unidad de Reclutamiento');
            return redirect()->route('replacement_staff.request.own_index');
        }
    }

    public function store_extension(Request $request, RequestReplacementStaff $requestReplacementStaff, $formType)
    {
        /* SE OBTIENEN LA INFORMACIÓN DEL FORMULARIO */
        $newRequestReplacementStaff = new RequestReplacementStaff($request->All());
        $newRequestReplacementStaff->form_type = $formType;
        $newRequestReplacementStaff->request_id = $requestReplacementStaff->id;
        $newRequestReplacementStaff->user()->associate(Auth::user());
        $newRequestReplacementStaff->organizational_unit_id = Auth::user()->organizationalUnit->id;
        $newRequestReplacementStaff->requesterUser()->associate($request->requester_id);

        if($request->fundament_detail_manage_id != 6 && $request->fundament_detail_manage_id != 7){
            $newRequestReplacementStaff->request_status = 'pending';
        }
        else{
            $newRequestReplacementStaff->request_status = 'complete';
        }

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        if($request->hasFile('job_profile_file')){
            $file = $request->file('job_profile_file');
            $file_name = $now.'_job_profile';
            $newRequestReplacementStaff->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
        }

        $file_verification = $request->file('request_verification_file');
        $file_name_verification = $now.'_request_verification';
        $newRequestReplacementStaff->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');

        $newRequestReplacementStaff->save();

        $request_sing = new RequestSign();

        $request_sing->position = '1';
        $request_sing->ou_alias = 'leadership';
        $request_sing->organizational_unit_id = Auth::user()->organizationalUnit->id;
        $request_sing->request_status = 'pending';
        $request_sing->request_replacement_staff_id = $newRequestReplacementStaff->id;
        $request_sing->save();

        //SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS
        /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
        $notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, today(), 'manager');
        $notification_ou_manager->user->notify(new NotificationSign($newRequestReplacementStaff));

        $request_sing_uni_per = new RequestSign();

        $request_sing_uni_per->position = '2';
        $request_sing_uni_per->ou_alias = 'uni_per';
        $request_sing_uni_per->organizational_unit_id = 46;
        $request_sing_uni_per->request_replacement_staff_id = $newRequestReplacementStaff->id;
        $request_sing_uni_per->save();

        //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
        /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
        $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, today(), 'manager');
        $notification_reclutamiento_manager->user->notify(new NotificationNewRequest($newRequestReplacementStaff, 'reclutamiento'));
        $newRequestReplacementStaff->requesterUser->notify(new NotificationNewRequest($newRequestReplacementStaff, 'requester'));

        session()->flash('success', 'Estimados Usuario, se ha creado la Solicitud de Extensión Exitosamente');
        return redirect()->route('replacement_staff.request.own_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function show(RequestReplacementStaff $requestReplacementStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestReplacementStaff $requestReplacementStaff)
    {
        return view('replacement_staff.request.edit', compact('requestReplacementStaff'));
    }

    public function edit_replacement(RequestReplacementStaff $requestReplacementStaff)
    {
        return view('replacement_staff.request.edit_replacement', compact('requestReplacementStaff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        $requestReplacementStaff->fill($request->all());
        $requestReplacementStaff->requesterUser()->associate($request->requester_id);
        $now = Carbon::now()->format('Y_m_d_H_i_s');

        if($request->hasFile('job_profile_file')){
            //DELETE LAST
            Storage::disk('gcs')->delete($requestReplacementStaff->job_profile_file);

            $requestReplacementStaff->fill($request->all());

            $file = $request->file('job_profile_file');
            $file_name = $requestReplacementStaff->id.'_'.$now.'_job_profile';
            $requestReplacementStaff->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
        }

        if($request->hasFile('request_verification_file')){
            //DELETE LAST
            Storage::disk('gcs')->delete($requestReplacementStaff->request_verification_file);

            $file_verification = $request->file('request_verification_file');
            $file_name_verification = $requestReplacementStaff->id.'_'.$now.'_request_verification';
            $requestReplacementStaff->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');
        }

        $requestReplacementStaff->save();

        session()->flash('success', 'Su solicitud ha sido sido correctamente actualizada.');
        return redirect()->route('replacement_staff.request.own_index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestReplacementStaff $requestReplacementStaff)
    {
        //
    }

    public function show_file(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::disk('gcs')->response($requestReplacementStaff->job_profile_file);
    }

    public function download(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::disk('gcs')->download($requestReplacementStaff->job_profile_file);
    }

    public function show_verification_file(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::disk('gcs')->response($requestReplacementStaff->request_verification_file);
    }

    public function download_verification(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::disk('gcs')->download($requestReplacementStaff->request_verification_file);
    }

    public function request_by_dates(Request $request){
        $totalRequestByDates = collect(new RequestReplacementStaff);
        $pending    = 0;
        $complete   = 0;
        $rejected   = 0;

        // $replacementStaff = ReplacementStaff::where('run', $request->run)->first();

        // if($replacementStaff){
        //     $applicants = Applicant::where('replacement_staff_id', $replacementStaff->id)
        //         ->where('selected', 1)
        //         ->get();
        //     return view('replacement_staff.reports.replacement_staff_historical', compact('request', 'replacementStaff', 'applicants'));
        // }
        return view('replacement_staff.reports.request_by_dates', compact('totalRequestByDates', 'request', 'pending', 'complete', 'rejected'));
    }

    public function search_request_by_dates(Request $request){
        $totalRequestByDates = RequestReplacementStaff::whereBetween('created_at', [$request->start_date_search, $request->end_date_search." 23:59:59"])->get();
        // $arrayRequests = [
        //     'Estado de Solicitud' => 'Cantidad',
        //     'pending'   => 0,
        //     'complete'  => 0,
        //     'rejected'  => 0
        // ];
        
        $pending    = 0;
        $complete   = 0;
        $rejected   = 0;

        foreach($totalRequestByDates as $totalRequestByDate){
            if($totalRequestByDate->request_status == 'pending'){
                //$arrayRequests['pending'] = $arrayRequests['pending'] + 1;
                $pending = $pending + 1;
            }
            if($totalRequestByDate->request_status == 'complete'){
                //$arrayRequests['complete'] = $arrayRequests['complete'] + 1;
                $complete = $complete + 1;
            }
            if($totalRequestByDate->request_status == 'rejected'){
                // $arrayRequests['rejected'] = $arrayRequests['rejected'] + 1;
                $rejected = $rejected + 1;
            }
        }

        return view('replacement_staff.reports.request_by_dates', compact('totalRequestByDates', 'request', 'pending', 'complete', 'rejected'));
    }
    
}
