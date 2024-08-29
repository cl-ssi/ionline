<?php

namespace App\Livewire\Documents;

use App\Models\Documents\Document;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DocumentMgr extends Component
{
    public $document_id;
    public $document;

    public function search()
    {
        $this->document = Document::find($this->document_id);

        if(!$this->document) {
            session()->flash('danger', 'No se encontró el documento');
        }
    }

    /**
    * Delete number
    */
    public function deleteNumber()
    {
        $this->document->number = null;
        $this->document->save();
    }

    public function deleteUploadedFile()
    {
        Storage::delete($this->document->file);

        $this->document->file = null;
        $this->document->save();
    }

    public function deleteDocument()
    {
        if($this->document->number) {
            $this->deleteNumber();
        }
        if($this->document->file) {
            $this->deleteUploadedFile();
        }

        $this->document->delete();

        unset($this->document);
        $this->document_id = null;

        session()->flash('danger', 'El documento ha sido eliminado');
    }

    public function render()
    {
        return view('livewire.documents.document-mgr');
    }
}
