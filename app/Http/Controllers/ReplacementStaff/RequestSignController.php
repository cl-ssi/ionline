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

            $nextRequestSign = $requestSign->requestReplacementStaff->requestSign->where('position', $requestSign->position + 1);
            
            if(!$nextRequestSign->isEmpty()){
                $nextRequestSign = $requestSign->requestReplacementStaff->requestSign->where('position', $requestSign->position + 1)->first();
                $nextRequestSign->request_status = 'pending';
                $nextRequestSign->save();

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
                return redirect()->route('replacement_staff.request.to_sign');
            }
            else{
                $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, Carbon::now(), 'manager');
                $notification_reclutamiento_manager->user->notify(new NotificationEndSigningProcess($requestReplacementStaff));

                session()->flash('success', 'Su solicitud ha sido Aceptada en su totalidad.');
                return redirect()->route('replacement_staff.request.to_sign');
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
            $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, Carbon::now(), 'manager');
            $notification_reclutamiento_manager->user->notify(new NotificationRejectedRequest($requestReplacementStaff, 'reclutamiento'));
            $requestReplacementStaff->requesterUser->notify(new NotificationRejectedRequest($requestReplacementStaff, 'requester'));

            session()->flash('danger', 'Su solicitud ha sido Rechazada con éxito.');
            return redirect()->route('replacement_staff.request.to_sign');
        }

        // session()->flash('success', 'Su solicitud ha sido.');
        // return redirect()->route('replacement_staff.edit', $replacementStaff);
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
