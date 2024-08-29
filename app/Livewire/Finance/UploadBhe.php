<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\BheImport;
use Maatwebsite\Excel\Facades\Excel;

class UploadBhe extends Component
{
    use WithFileUploads;
    public $bhe;


    public function upload()
    {
        $this->validate([
            'bhe' => 'required|mimes:xlx,xls,xlsx|max:2048'
        ]);

        // dd($this->dtes->path());
        Excel::import(new BheImport, $this->bhe->path(), 'gcs');

        session()->flash('message', 'Archivo con BHE cargado exitosamente.');
    }
    
    public function render()
    {
        return view('livewire.finance.upload-bhe')->extends('layouts.bt4.app');;
    }
}
