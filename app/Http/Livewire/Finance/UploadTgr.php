<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TgrsImport;

class UploadTgr extends Component
{
    use WithFileUploads;
    public $tgrs;


    public function upload()
    {
        $this->validate([
            'tgrs' => 'required|mimes:xlx,xls|max:2048'
        ]);
        Excel::import(new TgrsImport, $this->tgrs->path(), 'gcs');
        app('debugbar')->info('hola');
        session()->flash('success', 'Archivo con tgr cargado exitosamente.');
    }



    public function render()
    {
        return view('livewire.finance.upload-tgr');
    }
}
