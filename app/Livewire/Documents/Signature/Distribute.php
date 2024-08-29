<?php

namespace App\Livewire\Documents\Signature;

use Livewire\Component;
use App\Models\User;
use App\Notifications\Signatures\SignedDocument;
use App\Models\Documents\Signature;

class Distribute extends Component
{
    public Signature $signature;

    /**
    * Distribuir el documento
    */
    public function distributeDocument(Signature $signature)
    {
        $signature->distribute();
    }

    public function render()
    {
        return view('livewire.documents.signature.distribute');
    }
}
