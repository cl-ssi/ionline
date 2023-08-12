<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

use App\Models\ServiceRequests\Fulfillment;

class PeriodData extends Component
{
    public Fulfillment $fulfillment;

    protected $rules = [
        'fulfillment.type' => 'required',
        'fulfillment.start_date' => 'required',
        'fulfillment.end_date' => 'required',
        'fulfillment.observation' => 'required'
    ];

    public function save(){
        $this->fulfillment->save();
        session()->flash("success", "Datos actualizados correctamente");
    }

    // public function delete(){
    //     dd(url()->current());
    //     // no se puede dejar un service request con cero periodos
    //     if($this->fulfillment->serviceRequest->fulfillments->count()==1){
    //         session()->flash("warning", "No se puede eliminar el período. Como mínimo debe existir un período de la solicitud.");
    //         return;
    //     }

    //     $this->fulfillment->delete();
    //     session()->flash("success", "Se ha eliminado el período");
    // }

    public function render()
    {
        return view('livewire.service-request.period-data');
    }
}
