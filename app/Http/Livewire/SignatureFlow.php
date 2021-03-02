<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SignatureFlow extends Component
{
    public $art;

    public function mount($art)
    {
        $this->art=$art;
    }

    public function render()
    {
        return view('livewire.signature-flow');
    }
}
