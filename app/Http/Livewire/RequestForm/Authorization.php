<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Rrhh\Authority;
use Carbon\Carbon;
use App\User;

class Authorization extends Component
{
    public $organizationalUnit, $userAuthority, $position, $requestForm, $eventType, $rejectedComment;
    public $lstSupervisorUser, $supervisorUser;

    protected $rules = [
        'rejectedComment' => 'required|min:6',
    ];

    protected $messages = [
        'rejectedComment.required'  => 'Debe ingresar un comentario antes de rechazar Formulario.',
        'rejectedComment.min'       => 'Mínimo 6 caracteres.',
    ];

    public function mount(RequestForm $requestForm, $eventType) {
      $this->eventType          = $eventType;
      $this->requestForm        = $requestForm;
      $this->rejectedComment    = '';
      //$this->organizationalUnit = $requestForm->organizationalUnit->name;
      $this->organizationalUnit = auth()->user()->organizationalUnit->name;
      $this->userAuthority      = auth()->user()->getFullNameAttribute();
      $this->position           = auth()->user()->position;
      if($eventType!='supply_event')
        $this->lstSupervisorUser  = User::where('organizational_unit_id', 37)->get();
    }

    public function acceptRequestForm() {
      $event = EventRequestForm::where('request_form_id', $this->requestForm->id)
                               ->where('event_type', $this->eventType)
                               ->where('status', 'created')->first();
      if(!is_null($event)){
           $this->requestForm->status = 'in_progress';
           $this->requestForm->save();
           $event->signature_date = Carbon::now();
           $event->position_signer_user = $this->position;
           $event->status  = 'approved';
           $event->signerUser()->associate(auth()->user());
           $event->save();
           session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' AUTORIZADO correctamente!');
           return redirect()->route('request_forms.leadership_index');
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Autorizar!');
      return redirect()->route('request_forms.leadership_index');
    }

    public function rejectRequestForm() {
      $this->validate();
      $event = EventRequestForm::where('request_form_id', $this->requestForm->id)
                               ->where('event_type', $this->eventType)
                               ->where('status', 'created')->first();
      if(!is_null($event)){
           $this->requestForm->status = 'rejected';
           $this->requestForm->save();
           $event->signature_date = Carbon::now();
           $event->comment = $this->rejectedComment;
           $event->position_signer_user = $this->position;
           $event->status = 'rejected';
           $event->signerUser()->associate(auth()->user());
           $event->save();
           session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' fue RECHAZADO!');
           return redirect()->route('request_forms.leadership_index');
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Rechazar!');
      return redirect()->route('request_forms.leadership_index');
    }

    public function render() {
        return view('livewire.request-form.authorization');
    }
}
