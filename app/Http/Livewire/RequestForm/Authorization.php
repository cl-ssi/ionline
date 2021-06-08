<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;
use App\Rrhh\Authority;
use Carbon\Carbon;
use App\User;

class Authorization extends Component
{
    public $organizationalUnit, $userAuthority, $position, $requestForm, $eventType, $rejectedComment;
    public $lstSupervisorUser, $supervisorUser, $title, $route;
    public $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit;

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
      $this->organizationalUnit = auth()->user()->organizationalUnit->name;
      $this->userAuthority      = auth()->user()->getFullNameAttribute();
      $this->position           = auth()->user()->position;
      if($eventType=='supply_event'){
          $this->lstSupervisorUser  = User::where('organizational_unit_id', 37)->get();
          $this->lstPurchaseType   = PurchaseType::all();
          $this->lstPurchaseUnit   = PurchaseUnit::all();
          $this->title = 'Autorización Abastecimiento';
          $this->route = 'request_forms.supply_index';
      }elseif($eventType=='finance_event'){
          $this->title = 'Autorización Finanzas';
          $this->route = 'request_forms.finance_index';
      }elseif($eventType=='leader_ship_event'){
          $this->title = 'Autorización Jefatura';
          $this->route = 'request_forms.leadership_index';
      }
    }


    public function resetError(){
      $this->resetErrorBag();
    }


    public function acceptRequestForm()
    {
      if($this->eventType=='supply_event'){
        $this->validate(
          [ 'supervisorUser'  =>  'required',
            'purchaseUnit'    =>  'required',
            'purchaseType'    =>  'required',
         ],
          [ 'supervisorUser.required'  =>  'Seleccione un Usuario.',
            'purchaseUnit.required'    =>  'Seleccione una unidad de compra.',
            'purchaseType.required'    =>  'Seleccione un tipo de compra.',
         ]
        );
        $this->requestForm->supervisor_user_id =  $this->supervisorUser;
        $this->requestForm->purchase_unit_id   =  $this->purchaseUnit;
        $this->requestForm->purchase_type_id   =  $this->purchaseType;
      }
      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'created')->first();
      if(!is_null($event)){
           $this->requestForm->status = 'in_progress';
           $this->requestForm->save();
           $event->signature_date = Carbon::now();
           $event->position_signer_user = $this->position;
           $event->status  = 'approved';
           $event->signerUser()->associate(auth()->user());
           $event->save();
           session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' AUTORIZADO correctamente!');
           return redirect()->route($this->route);
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Autorizar!');
      return redirect()->route($this->route);
    }


    public function rejectRequestForm() {
      $this->validate();
      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'created')->first();
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
           return redirect()->route($this->route);
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->id.' NO se puede Rechazar!');
      return redirect()->route($this->route);
    }


    public function render() {
        return view('livewire.request-form.authorization');
    }
}
