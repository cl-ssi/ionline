<?php

namespace App\Http\Livewire\ServiceRequest;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;

class PaymentReadyToggle extends Component
{
    public $payment_ready;
    public $fulfillment;
    public $rejection_detail;
    public $rejection_detail_input;
    public $bg_color;
    public $payment_ready_text;

    public function mount()
    {
        $this->rejection_detail = $this->fulfillment->payment_rejection_detail;
        $this->payment_ready = $this->fulfillment->payment_ready;
    }

    public function save()
    {
        if ($this->rejection_detail_input) {
            $rejection_detail = $this->fulfillment->payment_rejection_detail . 
                "<hr>" . Auth::user()->initials . "-" . Carbon::now() . ":<br>" . 
                $this->rejection_detail_input;
        } else {
            if($this->payment_ready == 1)
            {
                $rejection_detail = $this->fulfillment->payment_rejection_detail . 
                    "<hr>" . Auth::user()->initials . "-" . Carbon::now() . ":<br> Pago Aceptado" ;
            }
            else
            {
                $rejection_detail = $this->fulfillment->payment_rejection_detail . 
                    "<hr>" . Auth::user()->initials . "-" . Carbon::now() . ":<br> Pago Rechazado" ;
            }

        }

        $this->fulfillment->update(['payment_ready' => $this->payment_ready == 'null' ? null : $this->payment_ready]);
        $this->fulfillment->update(['payment_rejection_detail' => $rejection_detail]);
        $this->rejection_detail = $rejection_detail;
        $this->payment_ready = $this->fulfillment->payment_ready;
    }



    public function render()
    {
        switch ($this->payment_ready) {
            case '0':
                $this->bg_color = 'bg-danger text-white';
                $this->payment_ready_text="Rechazado";
                break;
            case '1':
                $this->bg_color = 'bg-success text-white';
                $this->payment_ready_text="Aceptado";
                break;
            case null:
                $this->bg_color = 'bg-light';
                $this->payment_ready_text="Indeterminado";
                break;
        }
        return view('livewire.service-request.payment-ready-toggle');
    }
}
