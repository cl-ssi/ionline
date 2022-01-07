<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\BudgetItem;
use App\Rrhh\Authority;
use Carbon\Carbon;
//use App\User;

class PrefinanceAuthorization extends Component
{
    public $organizationalUnit, $userAuthority, $position, $requestForm, $eventType, $rejectedComment,
           $lstBudgetItem, $program, $sigfe, $codigo;
    public $arrayItemRequest = [['budgetId' => '']];
    public $round_trips, $baggages;

    protected $rules = [
        'rejectedComment' => 'required|min:6',
    ];


    protected $messages = [
        'rejectedComment.required'  => 'Debe ingresar un comentario antes de rechazar Formulario.',
        'rejectedComment.min'       => 'Mínimo 6 caracteres.',
    ];


    public function mount(RequestForm $requestForm, $eventType, $roundTrips, $baggages) {
      $this->eventType          = $eventType;
      $this->requestForm        = $requestForm;
      $this->round_trips        = $roundTrips;
      $this->baggages           = $baggages;
      $this->rejectedComment    = '';
      $this->codigo             = '';
      $this->lstBudgetItem      = BudgetItem::all();
      $this->organizationalUnit = auth()->user()->organizationalUnit->name;
      $this->userAuthority      = auth()->user()->getFullNameAttribute();
      $this->position           = auth()->user()->position;
      $this->program            = $requestForm->program;
      $this->sigfe              = $requestForm->sigfe;
    }


    public function resetError(){
      $this->resetErrorBag();
    }


    public function acceptRequestForm() {
      $this->validate(
        [
            'sigfe'                        =>  'required',
            'program'                      =>  'required',
            'arrayItemRequest'             =>  'required|min:'.(count($this->requestForm->itemRequestForms)+1)
        ],
        [
            'sigfe.required'               =>  'Ingrese valor para  SIGFE.',
            'program.required'             =>  'Ingrese un Programa Asociado.',
            'arrayItemRequest.min'         =>  'Debe seleccionar todos los items presupuestario.',
        ],
      );
      foreach($this->requestForm->itemRequestForms as $item){
        $item->budget_item_id = $this->arrayItemRequest[$item->id]['budgetId'];
        $item->save();
      }
      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'pending')->first();
      if(!is_null($event)){
          //  $this->requestForm->status = 'pending';
           $this->requestForm->program = $this->program;
           $this->requestForm->sigfe = $this->sigfe;
           $this->requestForm->save();
           $event->signature_date = Carbon::now();
           $event->position_signer_user = $this->position;
           $event->status  = 'approved';
           $event->signerUser()->associate(auth()->user());
           $event->save();
           session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' AUTORIZADO correctamente!');
           return redirect()->route('request_forms.pending_forms');
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Autorizar!');
      return redirect()->route('request_forms.pending_forms');
    }


    public function rejectRequestForm() {
      $this->validate();
      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'pending')->first();
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
           return redirect()->route('request_forms.pending_forms');
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Rechazar!');
      return redirect()->route('request_forms.pending_forms');
    }


    public function render() {
        return view('livewire.request-form.prefinance-authorization');
    }
}
