<?php

namespace App\Http\Livewire\Documents\Partes;

use Livewire\Component;
use App\Traits\NumerateTrait;
use App\Models\Documents\Numeration;

class NumerationInbox extends Component
{
    use NumerateTrait;

    public $error_msg;

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
