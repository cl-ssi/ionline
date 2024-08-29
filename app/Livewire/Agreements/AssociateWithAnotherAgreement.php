<?php

namespace App\Livewire\Agreements;

use App\Models\Agreements\Agreement;
use Livewire\Component;

class AssociateWithAnotherAgreement extends Component
{
    public $agreement_id;
    public $associateAgreement;

    public function mount()
    {
        $this->agreement = Agreement::find($this->agreement_id);
        $this->associateAgreement = $this->agreement->agreement_id;
    }

    public function associate()
    {
        $this->agreement->update(['agreement_id' => $this->associateAgreement]);
    }

    public function render()
    {
        return view('livewire.agreements.associate-with-another-agreement');
    }
}
