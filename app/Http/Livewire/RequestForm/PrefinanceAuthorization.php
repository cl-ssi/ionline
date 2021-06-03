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
    public $arrayItemRequest = [
            [
              'budgetId' => ''
            ]
    ];


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
      //$this->arrayItemRequest   = array();
      $this->codigo             = '';
      $this->lstBudgetItem      = BudgetItem::all();
      $this->organizationalUnit = auth()->user()->organizationalUnit->name;
      $this->userAuthority      = auth()->user()->getFullNameAttribute();
      $this->position           = auth()->user()->position;
      $this->program            = $requestForm->program;
      $this->sigfe              = $requestForm->sigfe;
    }

    public function acceptRequestForm()
    {
      /*
      $event = EventRequestForm::where('request_form_id', $this->requestForm->id)
                               ->where('event_type', $this->eventType)
                               ->where('status', 'created')->first();
      if(!is_null($event)){
           $this->requestForm->status = 'in_progress';
           $this->requestForm->program = $this->program;
           $this->requestForm->sigfe = $this->sigfe;
           $this->requestForm->save();
           $event->signature_date = Carbon::now();
           $event->position_signer_user = $this->position;
           $event->status  = 'approved';
           $event->signerUser()->associate(auth()->user());
           $event->save();
           session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' AUTORIZADO correctamente!');
           return redirect()->route('request_forms.prefinance_index');
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Autorizar!');
      return redirect()->route('request_forms.prefinance_index');
      */
      //dd('Oscar');

      $strID = '';

      foreach($this->requestForm->itemRequestForms as $item){
        $item->budget_item_id = $this->arrayItemRequest[$item->id]['budgetId'];
      }

      foreach($this->requestForm->itemRequestForms as $item){
        $strID = $strID.'item id: '.$item->id.' -- budgetID: '.$item->budget_item_id.' ';
      }
      dd($strID);

      //$this->arrayItemRequest
      //dd($this->arrayItemRequest);
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
           return redirect()->route('request_forms.prefinance_index');
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Rechazar!');
      return redirect()->route('request_forms.prefinance_index');
    }

    public function render() {
        //$this->collectItemRequest->dd();
        return view('livewire.request-form.prefinance-authorization');
    }
}
