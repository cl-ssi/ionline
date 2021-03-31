<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

class PaymentReadyToggle extends Component
{
    public $payment_ready;
    public $fulfillment;
    public $rejection_detail;

    public function save()
    {
        $this->fulfillment->update(['payment_ready' => $this->payment_ready == 'null' ? null : $this->payment_ready]);
    }

    public function saveRejectionDetail()
    {
        $this->fulfillment->update(['payment_rejection_detail' => $this->rejection_detail]);
    }

    public function render()
    {
        if ($this->fulfillment->payment_ready === null) {
            $this->payment_ready = 'null';
        } elseif ($this->fulfillment->payment_ready === 1) {
            $this->payment_ready = '1';
        } elseif ($this->fulfillment->payment_ready === 0) {
            $this->payment_ready = '0';
        }

        $this->rejection_detail = $this->fulfillment->payment_rejection_detail;

        return view('livewire.service-request.payment-ready-toggle');
    }
}
