<?php

namespace App\Http\Livewire\Finance;

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
    public function upload()
    {
        $this->validate([
            'dtes' => 'required|mimes:xlx,xls|max:2048'
        ]);

        // dd($this->dtes->path());
        Excel::import(new DtesImport, $this->dtes->path(), 'gcs');

        session()->flash('message', 'Archivo con dtes cargado existosamente.');
    }
    
    public function render()
    {
        return view('livewire.finance.upload-dtes')->extends('layouts.bt4.app');
    }
}
