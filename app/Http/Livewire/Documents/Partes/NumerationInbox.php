<?php

namespace App\Http\Livewire\Documents\Partes;

use Livewire\Component;
use App\Models\Documents\Numeration;

class NumerationInbox extends Component
{
    /**
     * Numerate
     */
    public function numerate(Numeration $numeration)
    {
        $numeration->numerate();
        $numeration->numerator_id = auth()->id();
        $numeration->date = now();
        $numeration->save();
    }

    public function render()
    {
        $numerations = Numeration::where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->latest()
            ->get();

        return view('livewire.documents.partes.numeration-inbox', [
            'numerations' => $numerations,
        ]);
    }
}
