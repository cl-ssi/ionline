<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PaymentDoc;

class PaymentDocsMgr extends Component
{
    public RequestForm $requestForm;
    public PaymentDoc $paymentDoc; // *

    public $form = false;

    /**
    * Save
    */
    public function save()
    {
        $this->paymentDoc->save(); // *
    }

    public function render()
    {
        /* Para debug lo tengo en true, pero se debe habilitar con el botón "+" */
        $this->form = true;
        return view('livewire.request-form.payment-docs-mgr');
    }
}
