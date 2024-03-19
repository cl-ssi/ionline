<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;

use App\Models\Welfare\Benefits\Request;

class RequestsAdmin extends Component
{
    public $requests;
    public $status_update_observation;
    public $accepted_amount;

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

    public function saveObservation($id){
        $request = Request::find($id);
        $request->status_update_observation = $this->status_update_observation;
        $request->save();
        $this->render();
    }

    public function saveAcceptedAmount($id){
        $request = Request::find($id);

        // verificación no se pase monto del tope anual
        $disponible_ammount = $request->subsidy->annual_cap - $request->getSubsidyUsedMoney();
        
        if($this->accepted_amount > $disponible_ammount){
            session()->flash('info', 'No es posible guardar el valor puesto que excede el tope anual del beneficio.');
        }else{
            $request->accepted_amount_date = now();
            $request->accepted_amount_responsable_id = auth()->user()->id;
            $request->accepted_amount = $this->accepted_amount;
            $request->save();
        }
        
        $this->render();
    }

    public function render()
    {
        $this->requests = Request::all();
        return view('livewire.welfare.benefits.requests-admin');;
        
    }
}
