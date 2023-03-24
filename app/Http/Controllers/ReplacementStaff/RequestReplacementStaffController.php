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
use App\Notifications\ReplacementStaff\NotificationSign;
use App\Notifications\ReplacementStaff\NotificationNewRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Parameters\Parameter;
use App\Models\ReplacementStaff\Position;

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
        // $pending_requests = RequestReplacementStaff::latest()
        //     ->WhereHas('technicalEvaluation', function($q) {
        //       $q->Where('technical_evaluation_status', 'pending');
        //     })
        //     ->WhereHas('assignEvaluations', function($j) {
        //       $j->Where('to_user_id', Auth::user()->id)
        //        ->where('status', 'assigned');
        //     })
        //     ->get();

        // $requests = RequestReplacementStaff::latest()
        //     ->WhereHas('technicalEvaluation', function($q) {
        //       $q->Where('technical_evaluation_status', 'complete')
        //       ->OrWhere('technical_evaluation_status', 'rejected');
        //     })
        //     ->WhereHas('assignEvaluations', function($j) {
        //       $j->Where('to_user_id', Auth::user()->id)
        //        ->where('status', 'assigned');
        //     })
        //     ->paginate(10);

        // return view('replacement_staff.request.assign_index', compact('pending_requests', 'requests'));

        return view('replacement_staff.request.assign_index');
    }

    public function own_index()
    {
        return view('replacement_staff.request.own_index');
    }

    public function personal_index()
    {
        return view('replacement_staff.request.personal_index');
    }

    public function pending_personal_index()
    {
        /*
        $requests = RequestReplacementStaff::latest()
            ->where('request_status', 'pending')
            ->paginate(15);

        return view('replacement_staff.request.pending_personal_index', compact('requests'));
        */
    }

    public function ou_index()
    {
        return view('replacement_staff.request.ou_index');
    }

    public function to_sign(RequestReplacementStaff $requestReplacementStaff)
    {
        $authorities = Authority::getAmIAuthorityFromOu(today(), 'manager', Auth::user()->id);
        $iam_authorities_in = array();

        foreach ($authorities as $authority){
            $iam_authorities_in[] = $authority->organizational_unit_id;
        }

        if($authorities->isNotEmpty()){
            $pending_requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) use ($authority, $iam_authorities_in){
                    $q->WhereIn('organizational_unit_id', $iam_authorities_in)
                    ->Where('request_status', 'pending');
                })
                ->get();

            $requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) use ($authority, $iam_authorities_in){
                    $q->Where('organizational_unit_id', $iam_authorities_in)
                    ->Where(function ($j){
                        $j->Where('request_status', 'accepted')
                        ->OrWhere('request_status', 'rejected');
                    });
                })
                ->paginate(10);
            return view('replacement_staff.request.to_sign', compact('iam_authorities_in', 'pending_requests_to_sign', 'requests_to_sign'));
        }
        else{
            if(Auth::user()->organizationalUnit->id == 46)
                $iam_authorities_in[] = 46;

            $pending_requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) {
                    $q->Where('organizational_unit_id', 46)
                    ->Where('request_status', 'pending');
                })
                ->get();

            $requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) {
                    $q->Where('organizational_unit_id', 46)
                    ->Where(function ($j){
                        $j->Where('request_status', 'accepted')
                        ->OrWhere('request_status', 'rejected');
                    });
                })
                ->paginate(10);
            return view('replacement_staff.request.to_sign', compact('iam_authorities_in', 'pending_requests_to_sign', 'requests_to_sign'));
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
        /*
        if(Auth::user()->organizationalUnit->level == 3){
            /* SE OBTIENEN LA INFORMACIÓN DEL FORMULARIO */
            if($formType == 'announcement'){
                $request_replacement = new RequestReplacementStaff();
                $request_replacement->name = $request->name;
                $request_replacement->request_status = 'pending';
                $request_replacement->ou_of_performance_id = $request->ou_of_performance_id;
                $position = new Position($request->All());
            }else{
                $request_replacement = new RequestReplacementStaff($request->All());
                /* CONDICIÓN DE CONVOCATORIA INTERNA O MIXTA */
                if($request->fundament_detail_manage_id != 6 && $request->fundament_detail_manage_id != 7){
                    $request_replacement->request_status = 'pending';
                }
                else{
                    $request_replacement->request_status = 'complete';
                }
            }

            $request_replacement->form_type = $formType;
            $request_replacement->user()->associate(Auth::user());
            $request_replacement->organizationalUnit()->associate(Auth::user()->organizationalUnit);
            $request_replacement->requesterUser()->associate($request->requester_id);

            $now = Carbon::now()->format('Y_m_d_H_i_s');
            if($request->hasFile('job_profile_file')){
                $file = $request->file('job_profile_file');
                $file_name = $now.'_job_profile';
                if($formType == 'announcement')
                    $position->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
                else
                    $request_replacement->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
            }

            $file_verification = $request->file('request_verification_file');
            $file_name_verification = $now.'_request_verification';
            $request_replacement->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');

            $request_replacement->save();
            if($formType == 'announcement') $request_replacement->positions()->save($position);

            $position = 1;
            
            for ($i = $request_replacement->organizationalUnit->level; $i >= 2; $i--) {
                if ($i > 2) {
                    $request_sing = new RequestSign();

                    $request_sing->position = $position;
                    $request_sing->ou_alias = 'leadership';
                    if($i == $request_replacement->organizationalUnit->level){
                        $request_sing->organizationalUnit()->associate($request_replacement->organizational_unit_id);
                        $request_sing->request_status = 'pending';

                        //SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS
                        $notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, today(), 'manager');
                        if($notification_ou_manager){
                            $notification_ou_manager->user->notify(new NotificationSign($request_replacement));
                        }
                    }
                    else{
                        $lastSign = RequestSign::
                            where('request_replacement_staff_id', $request_replacement->id)
                            ->latest()
                            ->first();
                        
                        $request_sing->organizationalUnit()->associate( $lastSign->organizationalUnit->father->id);
                    }

                    $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    $request_sing->save();
                    //dd($request_sing);
                }
                if ($i == 2){
                    $lastSign = RequestSign::    
                        where('request_replacement_staff_id', $request_replacement->id)
                        ->where('ou_alias', 'leadership')
                        ->orderBy('position', 'DESC')
                        ->first();
                    
                    if($lastSign && $lastSign->organizationalUnit->father->id != Parameter::where('module', 'ou')->where('parameter', 'SubRRHH')->first()->value){
                        $request_sing = new RequestSign();
                        $request_sing->position = $position;
                        $request_sing->ou_alias = 'sub';
                        $request_sing->organizationalUnit()->associate($lastSign->organizationalUnit->father->id);
                        $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                        $request_sing->save();
                    }
                    else{
                        if($i == $request_replacement->organizationalUnit->level){
                            $request_sing = new RequestSign();
                            $request_sing->position = $position;
                            $request_sing->ou_alias = 'sub';
                            $request_sing->organizationalUnit()->associate(Auth::user()->organizationalUnit);
                            $request_sing->request_status = 'pending';
                            $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                            $request_sing->save();
                        }
                        else{
                            $position = $position - 1;
                        }
                    }
                    
                    /*  APROBACION UNIDAD DE PERSONAL*/
                    $request_sing = new RequestSign();
                    $request_sing->position = $position + 1;
                    $request_sing->ou_alias = 'uni_per';
                    $request_sing->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'PersonalSSI')->first()->value);
                    $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    $request_sing->save();

                    /* APROBACIÓN RR.HH. */
                    $request_sing = new RequestSign();
                    $request_sing->position = $position + 2;
                    $request_sing->ou_alias = 'sub_rrhh';
                    $request_sing->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'SubRRHH')->first()->value);
                    $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    $request_sing->save();

                    /* APROBACIÓN FINANZAS */
                    $request_sing = new RequestSign();
                    $request_sing->position = $position + 3;
                    $request_sing->ou_alias = 'finance';
                    $request_sing->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value);
                    $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    $request_sing->save();

                    /* APROBACIÓN SDA SSI */
                    // $request_sing = new RequestSign();
                    // $request_sing->position = $position + 4;
                    // $request_sing->ou_alias = 'sub_adm';
                    // $request_sing->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'SDASSI')->first()->value);
                    // $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    // $request_sing->save();
                }
                $position++;
            }

            //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
            $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, today(), 'manager');
            if($notification_reclutamiento_manager){
                $notification_reclutamiento_manager->user->notify(new NotificationNewRequest($request_replacement, 'reclutamiento'));
            }
            //SE NOTIFICA A FUNCIONARIO SOLICITANTE
            $request_replacement->requesterUser->notify(new NotificationNewRequest($request_replacement, 'requester'));

            session()->flash('success', 'Estimados Usuario, se ha creado la Solicitud Exitosamente');
            return redirect()->route('replacement_staff.request.own_index');
        /*
        }
        else{
            session()->flash('danger', 'Estimado Usuario, su unidad organizacional no está autorizada para generar solicitudes, favor contactar a la Unidad de Reclutamiento');
            return redirect()->route('replacement_staff.request.own_index');
        }
        */
    }

    public function store_extension(Request $request, RequestReplacementStaff $requestReplacementStaff, $formType)
    {
        /* SE OBTIENEN LA INFORMACIÓN DEL FORMULARIO */
        $newRequestReplacementStaff = new RequestReplacementStaff($request->All());
        $newRequestReplacementStaff->form_type = $formType;
        $newRequestReplacementStaff->request_id = $requestReplacementStaff->id;
        $newRequestReplacementStaff->user()->associate(Auth::user());
        $newRequestReplacementStaff->organizationalUnit()->associate(Auth::user()->organizationalUnit->id);
        $newRequestReplacementStaff->requesterUser()->associate($request->requester_id);

        //REVISAR ESTO...
        if($request->fundament_detail_manage_id != 6 && $request->fundament_detail_manage_id != 7){
            $newRequestReplacementStaff->request_status = 'pending';
        }
        else{
            $newRequestReplacementStaff->request_status = 'complete';
        }
        //-------

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

        /* APROBACIÓN JEFATURA DIRECTA */
        $request_sing = new RequestSign();
        $request_sing->position = '1';
        $request_sing->ou_alias = 'leadership';
        $request_sing->organizationalUnit()->associate(Auth::user()->organizationalUnit->id);
        $request_sing->request_status = 'pending';
        $request_sing->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing->save();

        /* SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS */
        $notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, today(), 'manager');
        if($notification_ou_manager){
            $notification_ou_manager->user->notify(new NotificationSign($newRequestReplacementStaff));
        }

        /* APROBACIÓN UNIDAD PERSONAL */
        $request_sing_uni_per = new RequestSign();
        $request_sing_uni_per->position = '2';
        $request_sing_uni_per->ou_alias = 'uni_per';
        $request_sing_uni_per->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'PersonalSSI')->first()->value);
        $request_sing_uni_per->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing_uni_per->save();

        /* APROBACIÓN RR.HH. */
        $request_sing_rrhh = new RequestSign();
        $request_sing_rrhh->position = 3;
        $request_sing_rrhh->ou_alias = 'sub_rrhh';
        $request_sing_rrhh->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'SubRRHH')->first()->value);
        $request_sing_rrhh->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing_rrhh->save();

        /* APROBACIÓN DEPTO. FINANZAS */
        $request_sing_finance = new RequestSign();
        $request_sing_finance->position = '4';
        $request_sing_finance->ou_alias = 'finance';
        $request_sing_finance->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value);
        $request_sing_finance->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing_finance->save();

        //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
        $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, today(), 'manager');
        if($notification_reclutamiento_manager){
            $notification_reclutamiento_manager->user->notify(new NotificationNewRequest($newRequestReplacementStaff, 'reclutamiento'));
        }
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
        if($requestReplacementStaff->form_type == 'announcement')
            return view('replacement_staff.request.edit_announcement', compact('requestReplacementStaff'));
        else
            return view('replacement_staff.request.edit_replacement', compact('requestReplacementStaff'));
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
        // return $request;
        if($requestReplacementStaff->form_type == 'announcement'){
            $requestReplacementStaff->name = $request->name;
            $requestReplacementStaff->ou_of_performance_id = $request->ou_of_performance_id;
            $position = Position::find($request->position_id);
            if($position){
                $position->fill($request->all());
            }else{
                $position = new Position($request->All());
                $position->request_replacement_staff_id = $requestReplacementStaff->id;
            }
        }else{
            $requestReplacementStaff->fill($request->all());
        }
        $requestReplacementStaff->requesterUser()->associate($request->requester_id);
        $now = Carbon::now()->format('Y_m_d_H_i_s');

        if($request->hasFile('job_profile_file')){
            $file = $request->file('job_profile_file');
            $file_name = $requestReplacementStaff->id.'_'.$now.'_job_profile';
            if($requestReplacementStaff->form_type == 'announcement'){
                //DELETE LAST
                Storage::disk('gcs')->delete($position->job_profile_file);
                $position->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
            }else{
                Storage::disk('gcs')->delete($requestReplacementStaff->job_profile_file);
                $requestReplacementStaff->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
            }
        }

        if($request->hasFile('request_verification_file')){
            $file_verification = $request->file('request_verification_file');
            $file_name_verification = $requestReplacementStaff->id.'_'.$now.'_request_verification';
            Storage::disk('gcs')->delete($requestReplacementStaff->request_verification_file);
            $requestReplacementStaff->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');
        }

        $requestReplacementStaff->save();
        if($requestReplacementStaff->form_type == 'announcement' && ($request->create_new_position == 'yes' || !$request->has('create_new_position'))) $position->save();

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

    public function show_file_position(Position $position)
    {
        return Storage::disk('gcs')->response($position->job_profile_file);
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

        $continuity     = 0;
        $firstRequest   = 0;

        return view('replacement_staff.reports.request_by_dates', compact('totalRequestByDates', 
            'request', 'pending', 'complete', 'rejected', 'firstRequest', 'continuity'));
    }

    public function search_request_by_dates(Request $request){
        $totalRequestByDates = RequestReplacementStaff::whereBetween('created_at', [$request->start_date_search, $request->end_date_search." 23:59:59"])->get();
        
        $pending    = 0;
        $complete   = 0;
        $rejected   = 0;

        $continuity     = 0;
        $firstRequest   = 0;

        foreach($totalRequestByDates as $totalRequestByDate){
            /* Se cuentan Solicitudes por Estado */ 
            if($totalRequestByDate->request_status == 'pending'){
                $pending = $pending + 1;
            }
            if($totalRequestByDate->request_status == 'complete'){
                $complete = $complete + 1;
            }
            if($totalRequestByDate->request_status == 'rejected'){
                $rejected = $rejected + 1;
            }

            /* Se contabiliza Tipo de Solicitudes (Primer Formulario o Continuidad) */
            if($totalRequestByDate->request_id ){
                $continuity = $continuity + 1;
            }
            else{
                $firstRequest = $firstRequest + 1;
            }   
        }

        return view('replacement_staff.reports.request_by_dates', compact('totalRequestByDates', 
            'request', 'pending', 'complete', 'rejected', 'firstRequest', 'continuity'));
    }
    
}
