<?php

namespace App\Http\Livewire\Signatures;

use Livewire\Component;

class DocumentTypes extends Component
{
    public $selectedDocumentType;

    public function changeDocumentType(){
        $this->emit('documentTypeChanged', $this->selectedDocumentType);
    }

    public function render()
    {
        return view('livewire.signatures.document-types');
    }
}
