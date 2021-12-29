<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseMechanism;
use App\Rrhh\Authority;
use Carbon\Carbon;
use App\User;

class Authorization extends Component
{
    public $organizationalUnit, $userAuthority, $position, $requestForm, $eventType, $rejectedComment;
    public $lstSupervisorUser, $supervisorUser, $title, $route;
    public $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit, $lstPurchaseMechanism, $purchaseMechanism;
    public $estimated_expense, $purchaser_amount;

    protected $rules = [
        'rejectedComment' => 'required|min:6',
    ];

    protected $messages = [
        'rejectedComment.required'  => 'Debe ingresar un comentario antes de rechazar Formulario.',
        'rejectedComment.min'       => 'Mínimo 6 caracteres.',
    ];

    public function mount(RequestForm $requestForm, $eventType) {
      $this->route = 'request_forms.pending_forms';
      $this->eventType          = $eventType;
      $this->requestForm        = $requestForm;
      $this->rejectedComment    = '';
      $this->organizationalUnit = auth()->user()->organizationalUnit->name;
      $this->userAuthority      = auth()->user()->getFullNameAttribute();
      $this->position           = auth()->user()->position;
      if($eventType=='supply_event'){
          $this->lstSupervisorUser      = User::where('organizational_unit_id', 37)->get();
          //$this->lstPurchaseType        = PurchaseType::all();
          $this->purchaseMechanism      = $requestForm->purchase_mechanism_id;
          $this->lstPurchaseType        = PurchaseMechanism::find($this->purchaseMechanism)->purchaseTypes()->get();
          $this->lstPurchaseUnit        = PurchaseUnit::all();
          $this->lstPurchaseMechanism   = PurchaseMechanism::all();
          $this->title = 'Autorización Abastecimiento';
      }elseif($eventType=='finance_event'){
          $this->title = 'Autorización Finanzas';
      }elseif($eventType=='leader_ship_event'){
          $this->title = 'Autorización Jefatura';
      }elseif($eventType=='superior_leader_ship_event'){
          $this->title = 'Autorización Dirección';
      }elseif($eventType=='budget_event'){
          $this->title = 'Autorización Nuevo presupuesto';
          $this->estimated_expense = $requestForm->estimated_expense;
          $this->purchaser_amount = $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
      }
    }

    private function createPurchasingProcesses(){
      foreach($this->requestForm->itemRequestForms as $item){
        $purchasingProcess = new PurchasingProcess([
          'status'                  =>        'in_progress',
          'purchase_mechanism_id'   =>        $this->purchaseMechanism,
          'purchase_type_id'        =>        $this->purchaseType,
          'purchase_unit_id'        =>        $this->purchaseUnit,
        ]);
        $item->purchasingProcesses()->save($purchasingProcess);
      }
    }

    public function changePurchaseMechanism(){
      if($this->purchaseMechanism != "")
        $this->lstPurchaseType = PurchaseMechanism::find($this->purchaseMechanism)->purchaseTypes()->get();
      $this->purchaseType = "";
    }

    public function resetError(){
      $this->resetErrorBag();
    }


    public function acceptRequestForm()
    {
      if($this->eventType=='supply_event'){
        $this->validate(
          [ 'supervisorUser'    =>  'required',
            'purchaseUnit'      =>  'required',
            'purchaseType'      =>  'required',
            'purchaseMechanism' =>  'required',
         ],
          [ 'supervisorUser.required'     =>  'Seleccione Usuario.',
            'purchaseUnit.required'       =>  'Seleccione U. de compra.',
            'purchaseType.required'       =>  'Seleccione T. de compra.',
            'purchaseMechanism.required'  =>  'Seleccione M. de compra.',
         ]
        );
        // $this->requestForm->supervisor_user_id      =  $this->supervisorUser;
        $this->requestForm->purchase_unit_id        =  $this->purchaseUnit;
        $this->requestForm->purchase_type_id        =  $this->purchaseType;
        $this->requestForm->purchase_mechanism_id   =  $this->purchaseMechanism;
        $this->requestForm->purchasers()->attach($this->supervisorUser);
        $this->requestForm->status = 'approved';
        $this->requestForm->save();
        // $this->createPurchasingProcesses();
      }

      if($this->eventType=='budget_event'){
        $this->requestForm->update(['estimated_expense' => $this->purchaser_amount]);
      }

      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'pending')->first();
      if(!is_null($event)){
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
      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'pending')->first();
      if(!is_null($event)){
          if($this->eventType != 'budget_event'){
            $this->requestForm->status = 'rejected';
            $this->requestForm->save();
          }
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
