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
    public $msg = "";

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

//      $this->emit('listener_shift_control');
    }

    public function delete($shiftControl)
    {
      if ($shiftControl != null) {
        $shiftControl = ShiftControl::find($shiftControl['id']);
        $shiftControl->delete();

        $this->fulfillment = Fulfillment::find($this->fulfillment->id);
      }else{
        $this->msg = "No se encontró horario a eliminar. Intente nuevamente.";
        logger("Se intentó eliminar un shiftcontrol que venía vacío.");
      }
    }

    public function render()
    {
        return view('livewire.service-request.shifts-control');
    }
}
