<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class YearsWithContracts extends Component
{
    public $user_id;
    public $year;

    public function render()
    {
        /** Años en que tiene contratos */
        $yearsWithServiceRequests = ServiceRequest::where('user_id', $this->user_id)
            ->distinct()
            ->selectRaw('YEAR(start_date) as year')
            ->pluck('year')
            ->toArray();

        /** Array con rango de años entre el 2020 y el actual, todos seteados en false */
        $yearsRange = array_fill_keys(range(2020, date('Y')), false);

        /** Dejamos en true sólo aquellos que tiene contratos */
        foreach($yearsRange as $yearName => $value) {
            $yearsRange[$yearName] = in_array($yearName, $yearsWithServiceRequests) ??  false;
        }

        /**
         * Ej: dd($yearsRange) 
         * array:4 [
         *   2020 => false
         *   2021 => false
         *   2022 => true
         *   2023 => true
         * ]
         */

        return view('livewire.service-request.years-with-contracts', [
            'yearsRange' => $yearsRange,
        ]);
    }
}
