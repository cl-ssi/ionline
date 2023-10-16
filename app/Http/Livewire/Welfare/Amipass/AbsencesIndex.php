<?php

namespace App\Http\Livewire\Welfare\Amipass;

use App\Models\Welfare\Amipass\Absence;
use Livewire\Component;

class AbsencesIndex extends Component
{
    public function render()
    {
        return view('livewire.welfare.amipass.absences-index', [
            'records' => Absence::where('rut', auth()->id())
                ->paginate(50),
        ]);
    }
}
