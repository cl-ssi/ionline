<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Rrhh\Authority;
use Carbon\Carbon;
//use App\User;

class Authorization extends Component
{
    public $organizationalUnit, $userAuthority, $position, $requestForm;

    public function mount(RequestForm $requestForm){
      $this->requestForm        = $requestForm;
      $this->organizationalUnit = $requestForm->organizationalUnit->name;
      $this->userAuthority      = auth()->user()->getFullNameAttribute();
      $this->position           = Authority::getAmIAuthorityFromOu(Carbon::now(),'manager',auth()->user()->id)[0]->position;
    }

    public function acceptRequestForm(){
      $event = EventRequestForm::where('request_form_id', $this->requestForm->id)
                               ->where('event_type', 'leader_ship_event')
                               ->where('status', 'created')->first();
      if(!is_null($event)){
        $this->requestForm->status = 'in_progress';
        $this->requestForm->save();
        $event->signature_date = Carbon::now();
        $event->position_signer_user = $this->position;
        $event->status = 'approved';
        $event->signerUser()->associate(auth()->user());
        $event->save();
        session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' AUTORIZADO correctamente!');
        return redirect()->route('request_forms.leadership_index');
      }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Autorizar!');
      return redirect()->route('request_forms.leadership_index');
    }

    public function rejectRequestForm(){
    }

    public function render(){
        return view('livewire.request-form.authorization');
    }
}
