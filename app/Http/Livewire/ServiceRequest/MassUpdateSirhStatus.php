<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class MassUpdateSirhStatus extends Component
{
    public $ids;
    public $mensaje;

    public function massUpdate() {
        $this->mensaje = 'Se actualizó ids: ';
        $ids = explode("\n", $this->ids);
        foreach($ids as $id) {
            ServiceRequest::find($id)->update(['sirh_contract_registration' => 1]);
            $this->mensaje .= $id.', ';
        }
        
    }

    public function render()
    {
        return view('livewire.service-request.mass-update-sirh-status');
    }
}
