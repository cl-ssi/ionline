<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class ProgramContractTypes extends Component
{
    public $user_id;
    public $year;
    public $type;

    public function render()
    {
        $programContractTypes = [
            "Mensual" => false,
            "Horas" => false,
        ];

        $programContractTypesWithContracts = ServiceRequest::where('user_id', $this->user_id)
            ->whereYear('request_date', $this->year)
            ->distinct()
            ->pluck('program_contract_type')
            ->toArray();

        /** Dejamos en true sólo aquellos que tiene contratos */
        foreach($programContractTypes as $typeName => $value) {
            $programContractTypes[$typeName] = in_array($typeName, $programContractTypesWithContracts) ??  false;
        }

        return view('livewire.service-request.program-contract-types', [
            'programContractTypes' => $programContractTypes
        ]);
    }
}
