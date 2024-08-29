<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class WorkingDayTypes extends Component
{
    public $user_id;
    public $year;
    public $type;

    public function render()
    {
        $workingDayTypes = [
            "DIURNO" => false,
            "HORA EXTRA" => false,
            "HORA MÉDICA" => false,
            "TERCER TURNO" => false,
            "TERCER TURNO - MODIFICADO" => false,
            "CUARTO TURNO" => false,
            "CUARTO TURNO - MODIFICADO" => false,
            "TURNO DE REEMPLAZO" => false,
            "VESPERTINO" => false,
            // "TURNO EXTRA" => false,
            // "OTRO" => false,
            // "DIURNO PASADO A TURNO" => false,
            // "DIARIO" => false
        ];

        $workingDayTypesWithContracts = ServiceRequest::where('user_id', $this->user_id)
            ->whereYear('request_date', $this->year)
            ->distinct()
            ->pluck('working_day_type')
            ->toArray();

        /** Dejamos en true sólo aquellos que tiene contratos */
        foreach($workingDayTypes as $typeName => $value) {
            $workingDayTypes[$typeName] = in_array($typeName, $workingDayTypesWithContracts) ??  false;
        }

        return view('livewire.service-request.working-day-types', [
            'workingDayTypes' => $workingDayTypes
        ]);
    }
}
