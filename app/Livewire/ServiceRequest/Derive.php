<?php

namespace App\Livewire\ServiceRequest;

use App\Models\ServiceRequests\ServiceRequest;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\ServiceRequestNotification;
use App\Mail\DerivationNotification;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class Derive extends Component
{

    public $user_from_id;
    public $user_to_id;
    public $serviceRequestsMyPendingsCount;
    public $serviceRequestsOthersPendingsCount;

    public $mensaje = "";

    public $users;

    public $userFromSelected;
    public $userToSelected;

    public $type;

    public function derivar()
    {
        $establishment_id = auth()->user()->organizationalUnit->establishment_id;

        /* Acá va el código para derivar desde $user_form_id a $user_to_id */
        $user_from_id = $this->user_from_id;        
        $user_to_id = $this->user_to_id;
        $sender_name = User::find($user_from_id)->fullName;
        $receiver_name = User::find($user_to_id)->fullName;
        $receiver_email = User::find($user_to_id)->email;
        $type = $this->type;

        $serviceRequests = ServiceRequest::when($type != "Todas", function ($q) use ($type, $user_from_id) {
                                                return $q->whereHas("SignatureFlows", function ($subQuery) use ($type, $user_from_id) {
                                                            $subQuery->whereNull('status');
                                                            $subQuery->where('type',$type)
                                                                     ->where('responsable_id', $user_from_id);
                                                        });
                                            })
                                            ->when($type == "Todas", function ($q) use ($user_from_id) {
                                                return $q->whereHas("SignatureFlows", function ($subQuery) use ($user_from_id) {
                                                            $subQuery->whereNull('status');
                                                            $subQuery->where('responsable_id', $user_from_id);
                                                        });
                                            })
                                            // si es sst, se devuelve toda la info que no sea hetg ni hah.
                                            ->when($establishment_id == 38, function ($q) {
                                                return $q->whereNotIn('establishment_id', [1, 41]);
                                            })
                                            ->when($establishment_id != 38, function ($q) use ($establishment_id) {
                                                return $q->where('establishment_id',$establishment_id);
                                            })
                                            ->orderBy('id', 'asc')
                                            ->get();

        $cont = 0;
        $cant_rechazados = 0;
        foreach ($serviceRequests as $key => $serviceRequest) {
            if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() > 0) {
                $cant_rechazados += 1;
            } else {
                foreach ($serviceRequest->SignatureFlows->where('responsable_id', $user_from_id)->whereNull('status') as $key2 => $signatureFlow) {
                    $signatureFlow->responsable_id = $user_to_id;
                    $signatureFlow->derive_date = Carbon::now();
                    $signatureFlow->employee = User::find($user_to_id)->position . " (Traspasado desde " . $sender_name . ")";
                    $signatureFlow->save();
                    $cont += 1;
                }
            }
        }

        //send emails
        if ($cont > 0) {
            if (env('APP_ENV') == 'production') {
                Mail::to($receiver_email)->send(new DerivationNotification($cont, $sender_name, $receiver_name));
            }
        }

        $this->mensaje = $cont . ' solicitudes fueron derivadas.';
    }

    public function render()
    {
        $establishment_id = auth()->user()->organizationalUnit->establishment_id;

        if ($this->user_from_id != NULL) {
            $user_id = $this->user_from_id;
            $type = $this->type;

            $serviceRequestsOthersPendings = [];
            $serviceRequestsMyPendings = [];
            $serviceRequestsAnswered = [];
            $serviceRequestsCreated = [];
            $serviceRequestsRejected = [];

            $serviceRequests = ServiceRequest::when($type != "Todas", function ($q) use ($type,$user_id) {
                                                    return $q->whereHas("SignatureFlows", function ($subQuery) use ($type,$user_id) {
                                                                $subQuery->whereNull('status');
                                                                $subQuery->where('type',$type)
                                                                        ->where('responsable_id', $user_id);
                                                            });
                                                })
                                                ->when($type == "Todas", function ($q) use ($user_id) {
                                                    return $q->whereHas("SignatureFlows", function ($subQuery) use ($user_id) {
                                                                $subQuery->whereNull('status');
                                                                $subQuery->where('responsable_id', $user_id);
                                                            });
                                                })
                                                // si es sst, se devuelve toda la info que no sea hetg ni hah.
                                                ->when($establishment_id == 38, function ($q) {
                                                    return $q->whereNotIn('establishment_id', [1, 41]);
                                                })
                                                ->when($establishment_id != 38, function ($q) use ($establishment_id) {
                                                    return $q->where('establishment_id',$establishment_id);
                                                })
                                                ->orderBy('id', 'asc')
                                                ->with('SignatureFlows')
                                                ->get();

            foreach ($serviceRequests as $key => $serviceRequest) {
                //not rejected
                if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0) {
                    foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
                        //with responsable_id
                        if ($user_id == $signatureFlow->responsable_id) {
                            if ($signatureFlow->status == NULL) {
                                if ($serviceRequest->SignatureFlows->where('sign_position', $signatureFlow->sign_position - 1)->first()->status == NULL) {
                                    $serviceRequestsOthersPendings[$serviceRequest->id] = $serviceRequest;
                                } else {
                                    $serviceRequestsMyPendings[$serviceRequest->id] = $serviceRequest;
                                }
                            } else {
                                $serviceRequestsAnswered[$serviceRequest->id] = $serviceRequest;
                            }
                        }
                        //with organizational unit authority
                        if ($user_id == $signatureFlow->ou_id) {
                        }
                    }
                } else {
                    $serviceRequestsRejected[$serviceRequest->id] = $serviceRequest;
                }
            }


            foreach ($serviceRequests as $key => $serviceRequest) {
                if (!array_key_exists($serviceRequest->id, $serviceRequestsOthersPendings)) {
                    if (!array_key_exists($serviceRequest->id, $serviceRequestsMyPendings)) {
                        if (!array_key_exists($serviceRequest->id, $serviceRequestsAnswered)) {
                            $serviceRequestsCreated[$serviceRequest->id] = $serviceRequest;
                        }
                    }
                }
            }

            $this->serviceRequestsMyPendingsCount = count($serviceRequestsMyPendings);
            $this->serviceRequestsOthersPendingsCount = count($serviceRequestsOthersPendings);
        }

        return view('livewire.service-request.derive');
    }

    #[On('userFromSelected')]
    public function userFromSelected(User $user)
    {
        $this->user_from_id = $user->id;
    }

    #[On('userToSelected')]
    public function userToSelected(User $user)
    {
        $this->user_to_id = $user->id;
    }

}
