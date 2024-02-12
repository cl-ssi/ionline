<?php

namespace App\Http\Livewire\Documents\Partes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\NumerateTrait;
use App\Models\Documents\Numeration;

class NumerationInbox extends Component
{
    use NumerateTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $error_msg;

    public function render()
    {
        $numerations = Numeration::where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->latest()
            ->paginate(100);

        return view('livewire.documents.partes.numeration-inbox', [
            'numerations' => $numerations,
        ]);
    }
}
