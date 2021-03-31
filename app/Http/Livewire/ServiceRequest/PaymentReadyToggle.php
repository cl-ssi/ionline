<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

class PaymentReadyToggle extends Component
{
    public $payment_ready;
    public $fulfillment;
    public $rejection_detail;

    public function mount()
    {
        $this->rejection_detail = $this->fulfillment->payment_rejection_detail;
        $this->payment_ready = $this->fulfillment->payment_ready;
    }

    public function save()
    {
        $this->fulfillment->update(['payment_ready' => $this->payment_ready == 'null' ? null : $this->payment_ready]);
        $this->fulfillment->update(['payment_rejection_detail' => $this->rejection_detail]);
        $this->rejection_detail = $this->fulfillment->payment_rejection_detail;
        $this->payment_ready = $this->fulfillment->payment_ready;
    }

    public function render()
    {
        return view('livewire.service-request.payment-ready-toggle');
    }
}
