<?php

namespace App\Livewire\Finance;

use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Imports\DtesImport;


class UploadDtes extends Component
{
    use WithFileUploads;

    public $dtes;

    /**
    * upload
    */
    public function subir()
    {
        
        $this->validate([
            'dtes' => 'required|mimes:xlx,xls,xlsx|max:2048'
        ]);

        // dd($this->dtes->path());
        Excel::import(new DtesImport, $this->dtes->path());

        session()->flash('message', 'Archivo con dtes cargado exitosamente.');
    }
    
    public function render()
    {
        return view('livewire.finance.upload-dtes');
    }
}
