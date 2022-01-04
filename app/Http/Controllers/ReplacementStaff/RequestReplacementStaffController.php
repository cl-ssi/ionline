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
use App\Mail\NewRequestReplacementStaff;
use App\Mail\NotificationSign;
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
        $pending_requests = RequestReplacementStaff::latest()
            ->where('request_status', 'pending')
            ->where(function ($q){
                $q->doesntHave('technicalEvaluation')
                ->orWhereHas('technicalEvaluation', function( $query ) {
                  $query->where('technical_evaluation_status','pending');
                });
            })
            ->get();

        $requests = RequestReplacementStaff::latest()
            ->where('request_status', 'complete')
            ->orWhere(function ($q){
                $q->whereHas('requestSign', function($j) {
                    $j->Where('request_status', 'rejected');
                })
                ->orWhereHas('technicalEvaluation', function($y){
                    $y->Where('technical_evaluation_status', 'complete')
                    ->OrWhere('technical_evaluation_status', 'rejected');
                });
            })
            ->paginate(10);

        $users_rys = User::where('organizational_unit_id', 48)->get();

        return view('replacement_staff.request.index', compact('pending_requests', 'requests', 'users_rys'));
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
            ->get();

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
            ->get();

        //dd($requests);

        return view('replacement_staff.request.personal_index', compact('requests'));
    }

    // public function ou_index()
    // {
    //     $ou_request = RequestReplacementStaff::where('organizational_unit_id', Auth::user()->organizationalUnit->id)
    //         ->orderBy('id', 'DESC')
    //         ->paginate(10);
    //
    //     return view('replacement_staff.request.ou_index', compact('ou_request'));
    // }

    public function to_sign(RequestReplacementStaff $requestReplacementStaff)
    {
        $date = Carbon::now();
        $type = 'manager';
        $user_id = Auth::user()->id;

        $authorities = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

        foreach ($authorities as $authority){
            $iam_authorities_in[] = $authority->organizational_unit_id;
        }

        if(!empty($authorities)){
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
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        return view('replacement_staff.request.create', compact('ouRoots'));
    }

    public function create_extension(RequestReplacementStaff $requestReplacementStaff)
    {
        return view('replacement_staff.request.create_extension', compact('requestReplacementStaff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_replacement = new RequestReplacementStaff($request->All());
        $request_replacement->user()->associate(Auth::user());
        $request_replacement->organizational_unit_id = Auth::user()->organizationalUnit->id;

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

        $uo_request = OrganizationalUnit::where('id', $request_replacement->organizational_unit_id)
            ->get()
            ->last();


        if($request->fundament_detail_manage_id != 6 && $request->fundament_detail_manage_id != 7){
            // UO Nivel 1  Director
            if($uo_request->level == 1){

                for ($i = 1; $i <= 2; $i++) {

                    $request_sing = new RequestSign();

                    $date = Carbon::now()->format('Y_m_d_H_i_s');
                    $type = 'manager';
                    $type_adm = 'secretary';
                    $user_id = Auth::user()->id;

                    $iam_authority = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

                    if(!empty($iam_authority)){
                        if ($i == 1) {
                            $request_sing->position = '1';
                            $request_sing->ou_alias = 'sub_rrhh';
                            $request_sing->organizational_unit_id = 44;
                            $request_sing->request_status = 'pending';
                        }

                        if ($i == 2) {
                            $request_sing->position = '2';
                            $request_sing->ou_alias = 'dir';
                            $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                            $request_sing->request_status = 'accepted';
                        }
                    }
                    else{
                      if ($i == 1) {
                          $request_sing->position = '1';
                          $request_sing->ou_alias = 'sub_rrhh';
                          $request_sing->organizational_unit_id = 44;
                          $request_sing->request_status = 'pending';

                          //manager
                          $mail_notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type);
                          //secretary
                          $mail_notification_ou_secretary = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type_adm);

                          $emails = [$mail_notification_ou_manager->user->email, $mail_notification_ou_secretary->user->email];

                          Mail::to($emails)
                            ->cc(env('APP_RYS_MAIL'))
                            ->send(new NotificationSign($request_replacement));
                      }

                      if ($i == 2) {
                          $request_sing->position = '2';
                          $request_sing->ou_alias = 'dir';
                          $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                      }
                    }
                    $request_sing->request_replacement_staff_id = $request_replacement->id;
                    $request_sing->save();
                }
            }

            //UO Nivel 2 SUB Direcciones - Deptos.
            if($uo_request->level == 2){

                for ($i = 1; $i <= 3; $i++) {
                    $request_sing = new RequestSign();

                    $date = Carbon::now()->format('Y_m_d_H_i_s');
                    $type = 'manager';
                    $type_adm = 'secretary';
                    $user_id = Auth::user()->id;

                    $iam_authority = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

                    if(!empty($iam_authority)){
                        if($i == 1){
                            $request_sing->position = '1';
                            $request_sing->ou_alias = 'leadership';
                            $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                            $request_sing->request_status = 'accepted';
                        }
                        if ($i == 2) {
                            $request_sing->position = '2';
                            $request_sing->ou_alias = 'sub_rrhh';
                            $request_sing->organizational_unit_id = 44;
                            $request_sing->request_status = 'pending';
                        }

                        if ($i == 3) {
                            $request_sing->position = '2';
                            $request_sing->ou_alias = 'dir';
                            $request_sing->organizational_unit_id = $uo_request->father->id;
                        }
                    }
                    else{
                        if($i == 1){
                            $request_sing->position = '1';
                            $request_sing->ou_alias = 'leadership';
                            $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                            $request_sing->request_status = 'pending';

                            //manager
                            $mail_notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type);
                            //secretary
                            $mail_notification_ou_secretary = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type_adm);

                            $emails = [$mail_notification_ou_manager->user->email, $mail_notification_ou_secretary->user->email];

                            Mail::to($emails)
                              ->cc(env('APP_RYS_MAIL'))
                              ->send(new NotificationSign($request_replacement));
                        }
                        if ($i == 2) {
                            $request_sing->position = '2';
                            $request_sing->ou_alias = 'sub_rrhh';
                            $request_sing->organizational_unit_id = 44;
                        }

                        if ($i == 3) {
                            $request_sing->position = '3';
                            $request_sing->ou_alias = 'dir';
                            $request_sing->organizational_unit_id = $uo_request->father->id;
                        }
                    }
                    $request_sing->request_replacement_staff_id = $request_replacement->id;
                    $request_sing->save();
                }
            }

            //UO Nivel 3 Deptos. bajo SUB Direcciones.
            if($uo_request->level == 3){

                for ($i = 1; $i <= 3; $i++) {
                    $request_sing = new RequestSign();

                    $date = Carbon::now()->format('Y_m_d_H_i_s');
                    $type = 'manager';
                    $type_adm = 'secretary';
                    $user_id = Auth::user()->id;

                    $iam_authority = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

                    if(!empty($iam_authority)){
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
                          $mail_notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, Carbon::now(), $type);
                          //secretary
                          $type_adm = 'secretary';
                          $mail_notification_ou_secretary = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, Carbon::now(), $type_adm);

                          $emails = [$mail_notification_ou_manager->user->email, $mail_notification_ou_secretary->user->email];

                          Mail::to($emails)
                            ->cc(env('APP_RYS_MAIL'))
                            ->send(new NotificationSign($request_replacement));
                        }

                        if ($i == 3) {
                            $request_sing->position = '3';
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

                            //manager
                            $mail_notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type);
                            //secretary
                            $mail_notification_ou_secretary = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type_adm);

                            $emails = [$mail_notification_ou_manager->user->email, $mail_notification_ou_secretary->user->email];

                            Mail::to($emails)
                              ->cc(env('APP_RYS_MAIL'))
                              ->send(new NotificationSign($request_replacement));
                        }
                        if ($i == 2) {
                          $request_sing->position = '2';
                          $request_sing->ou_alias = 'sub';
                          $request_sing->organizational_unit_id = $uo_request->father->id;
                        }

                        if ($i == 3) {
                            $request_sing->position = '3';
                            $request_sing->ou_alias = 'sub_rrhh';
                            $request_sing->organizational_unit_id = 44;
                        }
                    }
                    $request_sing->request_replacement_staff_id = $request_replacement->id;
                    $request_sing->save();
                }
            }
        }
        Mail::to(explode(',', env('APP_RYS_MAIL')))->send(new NewRequestReplacementStaff($request_replacement));

        session()->flash('success', 'Estimados Usuario, se ha creado la Solicitud Exitosamente');
        return redirect()->route('replacement_staff.request.own_index');
    }

    public function store_extension(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        $newRequestReplacementStaff = new RequestReplacementStaff($request->All());
        $newRequestReplacementStaff->request_id = $requestReplacementStaff->id;
        $newRequestReplacementStaff->user()->associate(Auth::user());
        $newRequestReplacementStaff->organizational_unit_id = Auth::user()->organizationalUnit->id;
        $newRequestReplacementStaff->save();

        $request_sing = new RequestSign();

        $request_sing->position = '1';
        $request_sing->ou_alias = 'leadership';
        $request_sing->organizational_unit_id = Auth::user()->organizationalUnit->id;
        $request_sing->request_status = 'pending';
        $request_sing->request_replacement_staff_id = $newRequestReplacementStaff->id;
        $request_sing->save();

        //COPIA MAIL PARA FIRMAS
        $date = Carbon::now()->format('Y_m_d_H_i_s');
        $type = 'manager';
        $type_adm = 'secretary';
        //manager
        $mail_notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type);
        //secretary
        $mail_notification_ou_secretary = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type_adm);

        $emails = [$mail_notification_ou_manager->user->email, $mail_notification_ou_secretary->user->email];

        Mail::to($emails)
          ->cc(env('APP_RYS_MAIL'))
          ->send(new NotificationSign($newRequestReplacementStaff));

        //COPIA MAIL PARA FIRMAS
        Mail::to(explode(',', env('APP_RYS_MAIL')))->send(new NewRequestReplacementStaff($newRequestReplacementStaff));

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        if($request->hasFile('job_profile_file')){
            //DELETE LAST CV
            Storage::disk('gcs')->delete($requestReplacementStaff->job_profile_file);

            $requestReplacementStaff->fill($request->all());
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file = $request->file('job_profile_file');
            $file_name = $now.'_job_profile';
            $requestReplacementStaff->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
            $requestReplacementStaff->save();
        }
        else{
            $requestReplacementStaff->fill($request->all());
            $requestReplacementStaff->save();
        }

        session()->flash('success', 'Su solicitud ha sido sido correctamente actualizada.');
        return redirect()->route('replacement_staff.request.edit', $requestReplacementStaff);
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
}
