<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;

class PeriodsBar extends Component
{
    public ServiceRequest $serviceRequest;
    public $period;
    public $user_id;
    public $year;
    public $type;

    public function add_period(){
        $last_fulfillment = $this->serviceRequest->fulfillments->last();

        $fulfillment = new Fulfillment();
        $fulfillment->service_request_id = $last_fulfillment->service_request_id;
        $fulfillment->user_id = $last_fulfillment->user_id;
        $fulfillment->year = $last_fulfillment->start_date->addMonth()->format('Y');
        $fulfillment->month = $last_fulfillment->start_date->addMonth()->format('m');
        $fulfillment->type = $last_fulfillment->type;
        $fulfillment->start_date = $last_fulfillment->start_date->addMonth()->format('Y-m-d');
        $fulfillment->end_date = $last_fulfillment->start_date->addMonth()->endOfMonth()->format('Y-m-d');
        $fulfillment->save();

        $this->serviceRequest->refresh();
        $this->render();
    }

    public function render()
    {
        $periods = array();

        /* Llenar el arreglo con números del 1 al 12 como índice y false como valor */
        for ($i = 1; $i <= 12; $i++) {
            $periods[$i] = null;
        }

        $meses = array(
            1 => "Ene",
            2 => "Feb",
            3 => "Mar",
            4 => "Abr",
            5 => "May",
            6 => "Jun",
            7 => "Jul",
            8 => "Ago",
            9 => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dic"
        );

        $periodsAvailables = $this->serviceRequest->fulfillments->pluck('payment_date','month')->toArray();
        foreach($periodsAvailables as $periodAvailable => $date) {
            $periods[$periodAvailable] = $date ?? true;
        }

        return view('livewire.service-request.periods-bar', [
            'periods' => $periods,
            'meses' => $meses,
        ]);
    }
}
