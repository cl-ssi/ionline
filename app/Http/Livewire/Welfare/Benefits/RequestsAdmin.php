<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;

use App\Models\Welfare\Benefits\Request;

class RequestsAdmin extends Component
{
    public $requests;
    public $status_update_observation;

    // public function mount(){
    //     $this->requests = Request::all();
    // }

    // protected $rules = [
    //     'request.status_update_observation' => 'required'
    // ];

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

    public function render()
    {
        $this->requests = Request::all();
        return view('livewire.welfare.benefits.requests-admin');;
        
    }
}
