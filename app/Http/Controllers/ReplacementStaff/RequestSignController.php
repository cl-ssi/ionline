<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\RequestSign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Rrhh\Authority;
use Illuminate\Support\Facades\Mail;
// use App\Mail\NotificationSign;
use App\Notifications\ReplacementStaff\NotificationSign;
use App\Notifications\ReplacementStaff\NotificationRejectedRequest;
use App\Notifications\ReplacementStaff\NotificationEndSigningProcess;
use App\Models\ReplacementStaff\RequestReplacementStaff;
// use App\Mail\NotificationEndSigningProcess;
use App\User;
use App\Models\Parameters\Parameter;

class RequestSignController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function show(RequestSign $requestSign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestSign $requestSign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestSign $requestSign, $status, RequestReplacementStaff $requestReplacementStaff)
    {
        if($status == 'accepted'){
            $requestSign->user_id = Auth::user()->id;
            $requestSign->request_status = $status;
            $requestSign->date_sign = Carbon::now();
            $requestSign->save();

            if($request->has('budget_item_id')){
                $requestReplacementStaff->budget_item_id = $request->budget_item_id;
                $requestReplacementStaff->save();
            }

            $nextRequestSign = $requestSign->requestReplacementStaff->requestSign->where('position', $requestSign->position + 1);
            
            if(!$nextRequestSign->isEmpty()){
                $nextRequestSign = $requestSign->requestReplacementStaff->requestSign->where('position', $requestSign->position + 1)->first();
                $nextRequestSign->request_status = 'pending';
                $nextRequestSign->save();

                /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
                $notification_ou_manager = Authority::getAuthorityFromDate($nextRequestSign->organizational_unit_id, $requestSign->date_sign, 'manager');
                $users = [$notification_ou_manager->user]; 

                if($nextRequestSign->ou_alias == 'uni_per'){
                    $personal_users = User::latest()
                        ->whereHas('roles', function($q){
                            $q->Where('name', 'Replacement Staff: personal sign');
                        })
                        ->get();
                    foreach ($personal_users as $key => $personal_user) {
                        array_push($users , $personal_user);
                    }
                }

                // AQUI ENVIAR NOTIFICACIÓN DE AL NUEVO VISADOR.
                foreach ($users as $key => $user) {
                    $user->notify(new NotificationSign($requestReplacementStaff));
                }

                session()->flash('success', 'Su solicitud ha sido Aceptada con exito.');
                return redirect()->route('replacement_staff.request.to_sign_index');
            }
            else{
                // NOTIFICACION PARA RECLUTAMIENTO
                $notification_reclutamiento_manager = Authority::getAuthorityFromDate(Parameter::where('module', 'ou')->where('parameter', 'ReclutamientoSSI')->first()->value, today(), 'manager');
                if($notification_reclutamiento_manager){
                    $notification_reclutamiento_manager->user->notify(new NotificationEndSigningProcess($requestReplacementStaff));
                }
                session()->flash('success', 'Su solicitud ha sido Aceptada en su totalidad.');
                return redirect()->route('replacement_staff.request.to_sign_index');
            }

        }
        else{
            $requestSign->user_id = Auth::user()->id;
            $requestSign->request_status = $status;
            $requestSign->observation = $request->observation;
            $requestSign->date_sign = Carbon::now();
            $requestSign->save();

            $requestReplacementStaff->request_status = 'rejected';
            $requestReplacementStaff->save();

            //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
            $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, today(), 'manager');
            if($notification_reclutamiento_manager){
                $notification_reclutamiento_manager->user->notify(new NotificationRejectedRequest($requestReplacementStaff, 'reclutamiento'));
            }
            $requestReplacementStaff->requesterUser->notify(new NotificationRejectedRequest($requestReplacementStaff, 'requester'));
            $requestReplacementStaff->user->notify(new NotificationRejectedRequest($requestReplacementStaff, 'user'));

            session()->flash('danger', 'Su solicitud ha sido Rechazada con éxito.');
            return redirect()->route('replacement_staff.request.to_sign_index');
        }

        // session()->flash('success', 'Su solicitud ha sido.');
        // return redirect()->route('replacement_staff.edit', $replacementStaff);
    }

    public function massive_update(Request $request)
    {
        foreach($request->sign_id as $sign_id){
            $sign = RequestSign::where('id', $sign_id)->first();
            if($sign->ou_alias == "sub_rrhh"){
                $sign->user_id = Auth::user()->id;
                $sign->request_status = 'accepted';
                $sign->date_sign = now();
                $sign->save();
            }

            $nextRequestSign = $sign->requestReplacementStaff->requestSign->where('position', $sign->position + 1);

            if(!$nextRequestSign->isEmpty()){
                $nextRequestSign->first()->request_status = 'pending';
                $nextRequestSign->first()->save();

                $notification_ou_manager = Authority::getAuthorityFromDate($nextRequestSign->first()->organizational_unit_id, now(), 'manager');
                if($notification_ou_manager){
                    $notification_ou_manager->user->notify(new NotificationSign($nextRequestSign->first()->requestReplacementStaff));
                }
            }
        }

        session()->flash('success', 'Estimado Usuario: Sus solicitud(es) ha(n) sido Aceptada(s) en su totalidad.');
        return redirect()->route('replacement_staff.request.to_sign_index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestSign $requestSign)
    {
        //
    }
}
