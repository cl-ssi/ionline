<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;

use App\Models\Welfare\Benefits\Request;
use App\Models\Welfare\Benefits\Transfer;
use App\Notifications\Welfare\Benefits\RequestTransfer;

class RequestsAdmin extends Component
{
    public $requests;
    // public $status_update_observation = [];
    // public $accepted_amount = [];
    // public $installments_number = [];
    // public $payed_installments = [];
    // public $payed_amount = [];

    protected $rules = [
        'requests.*.status_update_observation' => 'required',
        'requests.*.accepted_amount' => 'required',
        'requests.*.installments_number' => 'required',

        'requests.*.transfers.*.payed_amount' => 'required',
    ];

    public function accept($id){
        $request = Request::find($id);
        $request->status = "Aceptado";
        $request->status_update_date = now();
        $request->status_update_responsable_id = auth()->user()->id;
        $request->save();
        $this->render();
    }

    public function reject($id){
        $request = Request::find($id);
        $request->status = "Rechazado";
        $request->status_update_date = now();
        $request->status_update_responsable_id = auth()->user()->id;
        $request->save();
        $this->render();
    }

    public function saveObservation($key){
        $this->requests[$key]->save();
        session()->flash('message', 'Se registró la observación.');
    }

    public function saveAcceptedAmount($key){
        $request = Request::find($this->requests[$key]->id);
        
        // verificación no se pase monto del tope anual (solo para subsidios con tope anual)
        if($request->subsidy->annual_cap != null){
            $disponible_ammount = $request->subsidy->annual_cap - $request->getSubsidyUsedMoney();

            if($this->requests[$key]->accepted_amount > $disponible_ammount){
                session()->flash('info', 'No es posible guardar el valor puesto que excede el tope anual del beneficio.');
                return;
            }
        }

        $request->accepted_amount_date = now();
        $request->accepted_amount_responsable_id = auth()->user()->id;
        $request->accepted_amount = $this->requests[$key]->accepted_amount;
        $request->save();

        session()->flash('message', 'Se registró el monto aceptado.');
    }

    public function saveInstallmentsNumber($key){
        $this->requests[$key]->save();
        for ($i = 0; $i < $this->requests[$key]->installments_number; $i++) {
            $transfer = new Transfer();
            $transfer->request_id = $this->requests[$key]->id;
            $transfer->installment_number = ($i + 1);
            $transfer->save();
        }
    }

    public function saveTransfer($key, $key2){
        $request = Request::find($this->requests[$key]->id);

        $transfer = Transfer::find($this->requests[$key]->transfers[$key2]->id);
        $transfer->payed_date = now();
        $transfer->payed_responsable_id = auth()->user()->id;
        $transfer->payed_amount = $this->requests[$key]->transfers[$key2]->payed_amount;
        $transfer->save();

        $flag = 0;
        foreach($transfer->request->transfers as $transfer){
            if($transfer->payed_amount == null){
                $flag = 1;
                
            }
        }
        if($flag == 0){
            $transfer->request->status = "Pagado";
            $transfer->request->save();
        }else{
            $transfer->request->status = "En proceso de pago";
            $transfer->request->save();
        }

        session()->flash('message', 'Se registró la transferencia.');

        // envia notificación
        // if (config('app.env') === 'production') {
            if($request->applicant){
                if($request->applicant->email_personal != null){
                    // Utilizando Notify 
                    $request->applicant->notify(new RequestTransfer($request, $this->requests[$key]->transfers[$key2]->payed_amount));
                } 
            }
        // }
    }

    public function saveTransferWithoutInstallments($key){
        $request = Request::find($this->requests[$key]->id);
        $request->status = "Pagado";
        $request->save();

        $transfer = new Transfer();
        $transfer->request_id = $request->id;
        $transfer->installment_number = 1;
        $transfer->payed_date = now();
        $transfer->payed_responsable_id = auth()->user()->id;
        $transfer->payed_amount = $request->accepted_amount;
        $transfer->save();

        session()->flash('message', 'Se registró la transferencia.');

        // envia notificación
        // if (config('app.env') === 'production') {
            if($request->applicant){
                if($request->applicant->email_personal != null){
                    // Utilizando Notify 
                    $request->applicant->notify(new RequestTransfer($request, $request->accepted_amount));
                } 
            }
        // }
    }

    public function render()
    {
        $this->requests = Request::all();
        // $this->refresh();
        return view('livewire.welfare.benefits.requests-admin');
        
    }
}
