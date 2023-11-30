<?php

namespace App\Http\Livewire\Documents\Partes;

use Livewire\Component;
use App\Models\Documents\Numeration;

class NumerationInbox extends Component
{
    public $message;

    /**
     * Numerate
     */
    public function numerate(Numeration $numeration)
    {

        $this->message = null;

        $status = $numeration->numerate();
        if ($status == true) {
            $numeration->numerator_id = auth()->id();
            $numeration->date = now();
            $numeration->save();
        } else {
            $this->message = $status;
        }
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
