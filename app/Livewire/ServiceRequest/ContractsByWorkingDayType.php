<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class ContractsByWorkingDayType extends Component
{
    public $user_id;
    public $year;
    public $type;
    public $service_request_id;

    public function render()
    {
        $serviceRequests = ServiceRequest::where('user_id', $this->user_id)
            ->whereYear('start_date', $this->year)
            ->where('working_day_type', $this->type)
            ->orderBy('start_date')
            ->get();

        return view('livewire.service-request.contracts-by-working-day-type',[
            'serviceRequests' => $serviceRequests,
        ]);
    }
}
