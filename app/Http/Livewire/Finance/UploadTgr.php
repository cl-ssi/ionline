<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TgrsImport;
use App\Imports\TgrsAccountingPortfolioImport;

class UploadTgr extends Component
{
    use WithFileUploads;
    public $tgrs;
    public $portfolios;
    


    public function upload()
    {
        $this->validate([
            'tgrs' => 'required|mimes:xlx,xls'
        ]);
        Excel::import(new TgrsImport, $this->tgrs->path(), 'gcs');
        session()->flash('success', 'Archivo de tgr cargado exitosamente.');
    }

    public function uploadAccountingPortfolio()
    {        
        $this->validate([
            'portfolios' => 'required|mimes:xlx,xls'
        ]);

        Excel::import(new TgrsAccountingPortfolioImport, $this->portfolios->path(), 'gcs');

        session()->flash('success', 'Archivo de tgr cargado exitosamente.');

    }



    public function render()
    {
        return view('livewire.finance.upload-tgr');
    }
}
