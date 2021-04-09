<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ShiftControl;
use App\Models\ServiceRequests\Fulfillment;

class ShiftsControl extends Component
{
    public $fulfillment;

    public $shift_start_date;
    public $start_hour;
    public $shift_end_date;
    public $end_hour;
    public $observation;

    public function save()
    {
      $shiftControl = new ShiftControl();
      $shiftControl->service_request_id = $this->fulfillment->service_request_id;
      $shiftControl->fulfillment_id = $this->fulfillment->id;
      $shiftControl->start_date = $this->shift_start_date . " " . $this->start_hour;
      $shiftControl->end_date = $this->shift_end_date . " " . $this->end_hour;
      $shiftControl->observation = $this->observation;
      $shiftControl->save();

      $this->fulfillment = Fulfillment::find($this->fulfillment->id);

      $this->emit('listener_shift_control');
    }

    public function delete($shiftControl)
    {
      $shiftControl = ShiftControl::find($shiftControl['id']);
      $shiftControl->delete();

      $this->fulfillment = Fulfillment::find($this->fulfillment->id);
    }

    public function render()
    {
        return view('livewire.service-request.shifts-control');
    }
}
