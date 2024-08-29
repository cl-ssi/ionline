<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class ContractsByProgramContractType extends Component
{
    public $user_id;
    public $year;
    public $type;
    public $service_request_id;

    public function render()
    {
        $serviceRequests = ServiceRequest::where('user_id', $this->user_id)
            ->whereYear('start_date', $this->year)
            ->where('program_contract_type', $this->type)
            ->orderBy('start_date')
            ->get();

        return view('livewire.service-request.contracts-by-program-contract-type',[
            'serviceRequests' => $serviceRequests,
        ]);
    }
}
