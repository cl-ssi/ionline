<?php

namespace App\Http\Livewire;

use Livewire\Component;
// use Livewire\WithFileUploads;

class TestFileManager extends Component
{

    // use WithFileUploads;

    protected $listeners = [
        'storeFiles',
    ];

    public function render()
    {
        return view('livewire.test-file-manager');
    }


    /**
    * Save
    */
    public function save()
    {
        // guardar el archivo
    }

    /**
    * storeFiles
    */
    public function storeFiles($file)
    {
        dd($file);
    }
}
