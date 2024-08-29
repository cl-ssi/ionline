<?php

namespace App\Livewire\Pharmacies;

use Livewire\Component;

class SignPurchaseRecord extends Component
{
    public $purchase;

    public function render()
    {
        return view('livewire.pharmacies.sign-purchase-record');
    }
}
