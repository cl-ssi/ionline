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

    public function mount()
    {
        $this->rejection_detail = $this->fulfillment->payment_rejection_detail;
        $this->payment_ready = $this->fulfillment->payment_ready;
    }

    public function save()
    {
        $rejection_detail = $this->fulfillment->payment_rejection_detail . "<br><br>" . "(". Carbon::now() . " - " . Auth::user()->initials .")" . ":" . $this->rejection_detail_input;

        $this->fulfillment->update(['payment_ready' => $this->payment_ready == 'null' ? null : $this->payment_ready]);
        $this->fulfillment->update(['payment_rejection_detail' => $rejection_detail]);
        $this->rejection_detail = $rejection_detail;
        $this->payment_ready = $this->fulfillment->payment_ready;
    }

    public function render()
    {
        switch($this->payment_ready) {
            case '0': $this->bg_color = 'bg-danger text-white'; break;
            case '1': $this->bg_color = 'bg-success text-white'; break;
            case null: $this->bg_color = 'bg-light'; break;
        }
        return view('livewire.service-request.payment-ready-toggle');
    }
}
