<?php

namespace App\Livewire\Signatures;

use Livewire\Component;
use App\Models\Documents\Type;

class DocumentTypes extends Component
{
    public $type_id;
    public $types;

    public function changeDocumentType(){
        $this->dispatch('documentTypeChanged', type_id: $this->type_id);
    }

    public function mount() {
        $this->types = Type::whereNull('partes_exclusive')->pluck('name','id');

        if (old('type_id')) {
            $this->selectedDocumentType = old('type_id');
        }
    }

    public function render()
    {
        return view('livewire.signatures.document-types');
    }
}