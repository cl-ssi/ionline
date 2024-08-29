<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use Carbon\Carbon;

use App\Models\ServiceRequests\Fulfillment;
use Illuminate\Support\Facades\Auth;

class PeriodRrhh extends Component
{
    public Fulfillment $fulfillment;

    protected $rules = [
        'fulfillment.total_hours_to_pay' => 'required',
        'fulfillment.total_to_pay' => 'required',
        'fulfillment.illness_leave' => '',
        'fulfillment.leave_of_absence' => '',
        'fulfillment.assistance' => '',
    ];

    protected $messages = [
        'fulfillment.total_hours_to_pay.required' => 'El campo es requerido.',
        'fulfillment.total_to_pay.required' => 'El campo es requerido.',
    ];

    public function save(){
        $this->validate();
        $this->fulfillment->save();
        session()->flash("period-rrhh", "Datos actualizados correctamente");
    }

    public function confirmFulfillment(Fulfillment $fulfillment)
    {
        // dd(auth()->user()->can('Service Request: fulfillments rrhh'));
        if (auth()->user()->can('Service Request: fulfillments responsable')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            $fulfillment->responsable_approbation = 1;
            $fulfillment->responsable_approbation_date = Carbon::now();
            $fulfillment->responsable_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->responsable_approbation = 1;
              $FulfillmentItem->responsable_approbation_date = Carbon::now();
              $FulfillmentItem->responsable_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        if (auth()->user()->can('Service Request: fulfillments rrhh')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            session()->flash("message", "No es posible aprobar, puesto que falta aprobación de Responsable.");
            $this->fulfillment->refresh();
            return 0;
          }
          if ($fulfillment->total_hours_to_pay == NULL) {
            session()->flash("message", 'No es posible aprobar, puesto que falta ingresar total de horas a pagar.');
            $this->fulfillment->refresh();
            return 0;
          }
          if ($fulfillment->total_to_pay == NULL) {
            session()->flash("message", 'No es posible aprobar, puesto que falta ingresar total a pagar.');
            $this->fulfillment->refresh();
            return 0;
          }
          
          if ($fulfillment->responsable_approver_id != NULL && $fulfillment->rrhh_approver_id == NULL) {
            $fulfillment->rrhh_approbation = 1;
            $fulfillment->rrhh_approbation_date = Carbon::now();
            $fulfillment->rrhh_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->rrhh_approbation = 1;
              $FulfillmentItem->rrhh_approbation_date = Carbon::now();
              $FulfillmentItem->rrhh_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }
        

        if (auth()->user()->can('Service Request: fulfillments finance')) {
          if ($fulfillment->rrhh_approver_id == NULL) {
            session()->flash("message", 'No es posible aprobar, puesto que falta aprobación de RRHH');
            $this->fulfillment->refresh();
            return 0;
          }
          if ($fulfillment->rrhh_approver_id != NULL && $fulfillment->finances_approver_id == NULL) {
            $fulfillment->finances_approbation = 1;
            $fulfillment->finances_approbation_date = Carbon::now();
            $fulfillment->finances_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->finances_approbation = 1;
              $FulfillmentItem->finances_approbation_date = Carbon::now();
              $FulfillmentItem->finances_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        session()->flash("message", 'Se ha confirmado la información del período.');
        $this->fulfillment->refresh();
    }

    public function refuseFulfillment(Fulfillment $fulfillment)
    {
        if (auth()->user()->can('Service Request: fulfillments responsable')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            $fulfillment->responsable_approbation = 0;
            $fulfillment->responsable_approbation_date = Carbon::now();
            $fulfillment->responsable_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->responsable_approbation = 0;
              $FulfillmentItem->responsable_approbation_date = Carbon::now();
              $FulfillmentItem->responsable_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        if (auth()->user()->can('Service Request: fulfillments rrhh')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            session()->flash('danger', 'No es posible rechazar, puesto que falta aprobación de Responsable.');
            return redirect()->back();
          }
          if ($fulfillment->responsable_approver_id != NULL && $fulfillment->rrhh_approver_id == NULL) {
            $fulfillment->rrhh_approbation = 0;
            $fulfillment->rrhh_approbation_date = Carbon::now();
            $fulfillment->rrhh_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->rrhh_approbation = 0;
              $FulfillmentItem->rrhh_approbation_date = Carbon::now();
              $FulfillmentItem->rrhh_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        if (auth()->user()->can('Service Request: fulfillments finance')) {
          if ($fulfillment->rrhh_approver_id == NULL) {
            session()->flash('danger', 'No es posible rechazar, puesto que falta aprobación de RRHH');
            return redirect()->back();
          }
          if ($fulfillment->rrhh_approver_id != NULL && $fulfillment->finances_approver_id == NULL) {
            $fulfillment->finances_approbation = 0;
            $fulfillment->finances_approbation_date = Carbon::now();
            $fulfillment->finances_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->finances_approbation = 0;
              $FulfillmentItem->finances_approbation_date = Carbon::now();
              $FulfillmentItem->finances_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        session()->flash('success', 'Se ha rechazado la información del período.');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.service-request.period-rrhh');
    }
}
