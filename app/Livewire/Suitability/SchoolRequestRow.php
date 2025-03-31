<?php

namespace App\Livewire\Suitability;

use Livewire\Component;
use App\Models\Suitability\PsiRequest;

class SchoolRequestRow extends Component
{
    public PsiRequest $psirequest;

    public function asdasdasdasd()
    {
        dd('asdasdads');
        $this->dispatch('prepareModal', $this->psirequest->id);
        // $this->dispatch('editInhability', $this->psirequest->id)->to(SchoolRequests::class);;
        // $emit('editInhability', $this->psirequest->id);
    }

    public function render()
    {
        return view('livewire.suitability.school-request-row');
    }
}
