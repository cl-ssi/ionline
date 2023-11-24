<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileMgr extends Component
{
    use WithFileUploads;
    public $file;

    public function render()
    {
        return view('livewire.file-mgr');
    }

    /**
    * emi
    */
    public function emitFile()
    {
        // dd($this->file);
        $this->emit('storeFiles', $this->file);
    }
}
