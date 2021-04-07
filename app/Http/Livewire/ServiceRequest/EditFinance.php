<?php

namespace App\Http\Livewire\ServiceRequest;

use Carbon\Carbon;
use Livewire\Component;

class EditFinance extends Component
{
    public $fulfillment;
    public $bill_number;
    public $total_hours_paid;
    public $total_paid;
    public $payment_date;
    public $contable_month;

    public function mount()
    {
        $this->bill_number = $this->fulfillment->bill_number;
        $this->total_hours_paid = $this->fulfillment->total_hours_paid;
        $this->total_paid = $this->fulfillment->total_paid;
        $this->payment_date = ($this->fulfillment->payment_date) ? Carbon::parse($this->fulfillment->payment_date)->format('Y-m-d') : null;
        $this->contable_month = $this->fulfillment->contable_month;
    }

    public function save()
    {
        $this->fulfillment->update(['bill_number' => $this->bill_number,
            'total_hours_paid' => $this->total_hours_paid,
            'total_paid' => $this->total_paid,
            'payment_date' => $this->payment_date,
            'contable_month' => $this->contable_month]);
    }

    public function render()
    {
        return view('livewire.service-request.edit-finance');
    }
}
