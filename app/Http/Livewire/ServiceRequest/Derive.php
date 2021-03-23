<?php

namespace App\Http\Livewire\ServiceRequest;

use App\Models\ServiceRequests\ServiceRequest;
use App\User;
use Carbon\Carbon;
use App\Mail\ServiceRequestNotification;
use App\Mail\DerivationNotification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Derive extends Component
{
    public $users;
    public $user_from_id;
    public $user_to_id;
    public $serviceRequestsMyPendingsCount;
    public $serviceRequestsOthersPendingsCount;

    public $mensaje = "";

    public function derivar(){

        /* Acá va el código para derivar desde $user_form_id a $user_to_id */

        $user_from_id = $this->user_from_id;
        $user_to_id = $this->user_to_id;
        $sender_name = User::find($user_from_id)->getFullNameAttribute();
        $receiver_name = User::find($user_to_id)->getFullNameAttribute();
        $receiver_email = User::find($user_to_id)->email;

        $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_from_id){
                                             $subQuery->whereNull('status');
                                             $subQuery->where('responsable_id',$user_from_id);
                                           })
                                           ->orderBy('id','asc')
                                           ->get();

        $cont = 0;
        $cant_rechazados = 0;
        foreach ($serviceRequests as $key => $serviceRequest) {
          if ($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0) {
            $cant_rechazados += 1;
          }
          else{
            foreach ($serviceRequest->SignatureFlows->where('responsable_id',$user_from_id)->whereNull('status') as $key2 => $signatureFlow) {
              $signatureFlow->responsable_id = $user_to_id;
              $signatureFlow->derive_date = Carbon::now();
              $signatureFlow->employee = User::find($user_to_id)->position . " (Traspasado desde ".$sender_name.")";
              $signatureFlow->save();
              $cont += 1;
            }
          }
        }

        //send emails
        if ($cont > 0) {
          if (env('APP_ENV') == 'production') {
            Mail::to($receiver_email)->send(new DerivationNotification($cont,$sender_name,$receiver_name));
          }
        }

        $this->mensaje = $cont . ' solicitudes fueron derivadas.';
    }

    public function render()
    {
        if ($this->user_from_id != NULL) {
          $user_id = $this->user_from_id;

          $serviceRequestsOthersPendings = [];
          $serviceRequestsMyPendings = [];
          $serviceRequestsAnswered = [];
          $serviceRequestsCreated = [];
          $serviceRequestsRejected = [];

          $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                               $subQuery->where('responsable_id',$user_id);
                                               $subQuery->orwhere('user_id',$user_id);
                                             })
                                             ->orderBy('id','asc')
                                             ->get();

          foreach ($serviceRequests as $key => $serviceRequest) {
            //not rejected
            if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0) {
              foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
                //with responsable_id
                if ($user_id == $signatureFlow->responsable_id) {
                  if ($signatureFlow->status == NULL) {
                    if ($serviceRequest->SignatureFlows->where('sign_position',$signatureFlow->sign_position-1)->first()->status == NULL) {
                      $serviceRequestsOthersPendings[$serviceRequest->id] = $serviceRequest;
                    }else{
                      $serviceRequestsMyPendings[$serviceRequest->id] = $serviceRequest;
                    }
                  }else{
                    $serviceRequestsAnswered[$serviceRequest->id] = $serviceRequest;
                  }
                }
                //with organizational unit authority
                if ($user_id == $signatureFlow->ou_id) {

                }
              }
            }
            else{
              $serviceRequestsRejected[$serviceRequest->id] = $serviceRequest;
            }
          }


          foreach ($serviceRequests as $key => $serviceRequest) {
            if (!array_key_exists($serviceRequest->id,$serviceRequestsOthersPendings)) {
              if (!array_key_exists($serviceRequest->id,$serviceRequestsMyPendings)) {
                if (!array_key_exists($serviceRequest->id,$serviceRequestsAnswered)) {
                  $serviceRequestsCreated[$serviceRequest->id] = $serviceRequest;
                }
              }
            }
          }

          $this->serviceRequestsMyPendingsCount = count($serviceRequestsMyPendings);
          $this->serviceRequestsOthersPendingsCount = count($serviceRequestsOthersPendings);
        }

        /* Mostrar sólo usuarios que tengan solicitudes para derivara para alivianar la vista */
        $this->users = User::orderBy('name','ASC')->get();
        return view('livewire.service-request.derive');
    }
}
