<?php

namespace App\Livewire\Requirements\Events;

use Livewire\Component;

use App\Models\Documents\Document;

class AssociateDocument extends Component
{
    public $doc_id;
    public $documents;
    public $message = '';
    public $parte_id;

    public function setDocument()
    {
        $this->message = '';

        if(!!Document::find($this->doc_id))
        {
            $this->documents[] = $this->doc_id;
            $this->doc_id = null;
        }
        else 
        {
            $this->message = 'no existe el número interno '. $this->doc_id;
        }

    }

    public function render()
    {
        return view('livewire.requirements.events.associate-document');
    }
}
