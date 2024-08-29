<?php

namespace App\Livewire\Programmings;

use Livewire\Component;

class ProgrammingStatusToggle extends Component
{
    public $programming, $checked;

    public function mount()
    {
        $this->checked = $this->programming->status == 'active';
    }

    public function updatingChecked($value)
    {
        $this->checked = $value;
        $this->programming->update(['status' => $this->checked ? 'active' : 'inactive']);
    }

    public function render()
    {
        return view('livewire.programmings.programming-status-toggle');
    }
}
