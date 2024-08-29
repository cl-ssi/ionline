<?php

namespace App\Livewire;

use Livewire\Component;

class TestModal extends Component
{
    public $showModal = null;
    public $file_url;

    public function show()
    {
        /** Codigo para generar el PDF */
        $this->file_url = asset('samples/sample.pdf');
        $this->showModal = 'd-block';
    }

    public function dismiss()
    {
        /** Codigo al cerrar el modal */
        $this->showModal = null;
    }

    public function sign() 
    {
        //Codigo que se ejecuta cuando presiona en firmar
    }

    public function render()
    {
        return view('livewire.test-modal');
    }
}
