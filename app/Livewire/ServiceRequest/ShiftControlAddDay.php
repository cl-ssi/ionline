<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ShiftControl;
use App\Models\ServiceRequests\Fulfillment;

class ShiftControlAddDay extends Component
{
  public $fulfillment;

  public $shift_start_date;
  // public $start_hour;
  // public $shift_end_date;
  // public $end_hour;
  public $observation;

  public function save()
  {
    $shiftControl = new ShiftControl();
    $shiftControl->service_request_id = $this->fulfillment->service_request_id;
    $shiftControl->fulfillment_id = $this->fulfillment->id;
    $shiftControl->start_date = $this->shift_start_date;
    $shiftControl->observation = $this->observation;
    $shiftControl->save();

    $this->fulfillment = Fulfillment::find($this->fulfillment->id);

//      $this->dispatch('listener_shift_control');
  }

  public function delete($shiftControl)
  {
    $shiftControl = ShiftControl::find($shiftControl['id']);
    $shiftControl->delete();

    $this->fulfillment = Fulfillment::find($this->fulfillment->id);
  }

  public function render()
  {
      return view('livewire.service-request.shift-control-add-day');
  }
}
