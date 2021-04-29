<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;

class ShowPartePdf extends Component
{
    public $parte;
    public $selectedKey;

    public function mount()
    {
        $this->selectedKey = 0;
    }

    public function render()
    {
        return view('livewire.requirements.show-parte-pdf');
    }
}
