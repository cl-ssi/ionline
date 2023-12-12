<?php

namespace App\Http\Livewire\IdentifyNeeds;

use Livewire\Component;

use App\Models\IdentifyNeeds\IdentifyNeed;

class SearchIdentifyNeed extends Component
{
    public $index;

    public function render()
    {
        if($this->index == 'own'){
            $identifyNeeds = IdentifyNeed::latest()
                ->where('organizational_unit_id', auth()->user()->organizational_unit_id)
                ->where('user_id', auth()->user()->id)
                ->get();
        }

        return view('livewire.identify-needs.search-identify-need', compact('identifyNeeds'));
    }
}
