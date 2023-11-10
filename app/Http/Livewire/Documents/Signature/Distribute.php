<?php

namespace App\Http\Livewire\Documents\Signature;

use Livewire\Component;
use App\User;
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
    
        $allEmails = $signature->recipients . ',' . $signature->distribution;

        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $allEmails, $valid_emails);

        /**
         * Utilizando notify y con colas
         */
        foreach($valid_emails[0] as $email) {
            // Crea un usuario en memoria para enviar la notificación
            $user = new User([ 'email' => $email]);
            $user->notify(new SignedDocument($signature));
        }
    }

    public function render()
    {
        return view('livewire.documents.signature.distribute');
    }
}
