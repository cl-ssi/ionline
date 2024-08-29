<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use App\Models\Documents\Document;
use App\Models\Documents\Correlative;

class Enumerate extends Component
{
    public Document $document;
    public $delete = false;
    
    /**
    * Enumerar
    */
    public function enumerate()
    {
        $this->document->number = Correlative::getCorrelativeFromType($this->document->type_id);
        $this->document->save();
        return redirect()->route('documents.index');
    }

    /**
    * delete number
    */
    public function deleteNumber()
    {
        $this->document->number = null;
        $this->document->save();
    }

    public function render()
    {
        return view('livewire.documents.enumerate');
    }
}
