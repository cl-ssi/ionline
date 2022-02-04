<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\FulfillmentItem;
use App\Models\ServiceRequests\Fulfillment;
use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;

class FulfillmentAbsences extends Component
{
    public $fulfillment;

    public $type;
    public $start_date = '00:00:00';
    public $start_hour;
    public $end_date;
    public $end_hour;
    public $observation;

    public $select_start_date;
    public $select_start_hour;
    public $select_end_date;
    public $select_end_hour;
    public $select_observation;

    public $msg;

    public function save()
    {
      $this->msg = "";
      if ($this->type == null) {
        $this->msg = "Debe seleccionar un tipo.";
        return;
      }


      switch ($this->type) {
      case 'Inasistencia Injustificada':
          if($this->end_date==null and $this->start_date==null){
            $this->msg = "No se pudo ingresar, debe existir fecha de inicio y fecha de término";
    				return;
          }
      case 'Licencia no covid':
        if($this->end_date==null and $this->start_date==null){
          $this->msg = "No se pudo ingresar, debe existir fecha de inicio y fecha de término";
          return;
        }
      case 'Abandono de funciones':
        if($this->end_date==null and $this->start_date==null){
          $this->msg = "No se pudo ingresar, debe existir fecha de inicio y fecha de término";
          return;
        }
      case 'Renuncia voluntaria':
        if($this->end_date==null){
          $this->msg = "No se pudo ingresar, debe existir fecha de término";
          return;
        }
      case 'Término de contrato anticipado':
        if($this->end_date==null){
          $this->msg = "No se pudo ingresar, debe existir fecha de término";
          return;
        }
      case 'Atraso':
        if($this->end_date==null and $this->start_date==null){
          $this->msg = "No se pudo ingresar, debe existir fecha de inicio y fecha de término";
          return;
        }
      }

      // //validation
      // if (Auth::user()->can('Service Request: fulfillments rrhh')) {
      //   if (Fulfillment::where('id',$this->fulfillment->id)->first()->responsable_approver_id == NULL) {
      //     // session()->flash('danger', 'No es posible registrar, puesto que falta aprobación de Responsable.');
      //     // return redirect()->back();
      //     $this->msg = "No es posible registrar, puesto que falta aprobación de Responsable.";
      //     return;
      //   }
      // }

      // if (Auth::user()->can('Service Request: fulfillments finance')) {
      //   if (Fulfillment::where('id',$this->fulfillment->id)->first()->rrhh_approver_id == NULL) {
      //     // session()->flash('danger', 'No es posible registrar, puesto que falta aprobación de RRHH.');
      //     // return redirect()->back();
      //     $this->msg = "No es posible registrar, puesto que falta aprobación de RRHH.";
      //     return;
      //   }
      // }

      if ($this->type != "Renuncia voluntaria" && $this->type != "Abandono de funciones" && $this->type != "Término de contrato anticipado") {
        $start = Carbon::parse($this->start_date . " " .$this->start_hour);
        $end = Carbon::parse($this->end_date . " " .$this->end_hour);
  			if ($start > $end) {
  				// alert("La fecha de salida es menor a la fecha de inicio, revise la información.");
          $this->msg = "La fecha de salida es menor a la fecha de inicio, revise la información.";
  				return;
  			}
      }

      //save
      $fulfillmentItem = new FulfillmentItem();
      $fulfillmentItem->fulfillment_id = $this->fulfillment->id;
      $fulfillmentItem->type = $this->type;
      switch($this->type) {
        case 'Inasistencia Injustificada':
        case 'Permiso':
        case 'Turno':
        case 'Atraso':
          $fulfillmentItem->start_date = $this->start_date . " " .$this->start_hour;
          $fulfillmentItem->end_date = $this->end_date . " " .$this->end_hour;
          break;
        case 'Licencia médica':
        case 'Licencia no covid':
        case 'Fuero maternal':
        //case 'Permiso':
        case 'Feriado':
          $fulfillmentItem->start_date = $this->start_date;
          $fulfillmentItem->end_date = $this->end_date;
          break;
        case 'Renuncia voluntaria':
        case 'Abandono de funciones':
        case 'Término de contrato anticipado':
          $fulfillmentItem->end_date = $this->end_date;
          break;

      }

      if (Auth::user()->can('Service Request: fulfillments responsable')) {
        $fulfillmentItem->responsable_approbation = 1;
        $fulfillmentItem->responsable_approbation_date = Carbon::now();
        $fulfillmentItem->responsable_approver_id = Auth::user()->id;
      }elseif(Auth::user()->can('Service Request: fulfillments rrhh')){
        $fulfillmentItem->rrhh_approbation = 1;
        $fulfillmentItem->rrhh_approbation_date = Carbon::now();
        $fulfillmentItem->rrhh_approver_id = Auth::user()->id;
      }
      elseif(Auth::user()->can('Service Request: fulfillments finance')){
        $fulfillmentItem->finances_approbation = 1;
        $fulfillmentItem->finances_approbation_date = Carbon::now();
        $fulfillmentItem->finances_approver_id = Auth::user()->id;
      }
      $fulfillmentItem->user_id = Auth::user()->id;
      $fulfillmentItem->save();

      $this->fulfillment = Fulfillment::find($this->fulfillment->id);
    }

    public function delete($fulfillmentItem)
    {
      $fulfillmentItem = FulfillmentItem::find($fulfillmentItem['id']);
      $fulfillmentItem->delete();

      $this->fulfillment = Fulfillment::find($fulfillmentItem['fulfillment_id']);
    }

    public function render()
    {
        $this->select_start_date = '';
        $this->select_start_hour = '';
        $this->select_end_date = '';
        $this->select_end_hour = '';
        $this->select_observation = '';

        switch($this->type) {
          case 'Licencia médica':
          case 'Licencia no covid':
          case 'Fuero maternal':
          case 'Feriado':
            $this->select_start_hour = 'disabled';
            $this->select_end_hour = 'disabled';
            break;
          case 'Renuncia voluntaria':
          case 'Abandono de funciones':
            $this->select_start_date = 'disabled';
            $this->select_start_hour = 'disabled';
            $this->select_end_hour = 'disabled';
            break;
          case 'Término de contrato anticipado':
            $this->select_start_date = 'disabled';
            $this->select_start_hour = 'disabled';
            $this->select_end_hour = 'disabled';
            break;
          default:
            break;
        }

        return view('livewire.service-request.fulfillment-absences');
    }
}
