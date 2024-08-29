<?php

namespace App\Livewire\Allowances\Imports;

use Livewire\Component;

use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AllowancesImport;

class ImportAllowances extends Component
{
    use WithFileUploads;

    public $file;

    public function render()
    {
        return view('livewire.allowances.imports.import-allowances');
    }

    public function import(){
        //$allowances = Excel::toCollection(new AllowancesImport, $this->file);
        Excel::import(new AllowancesImport, $this->file);
        // dd($allowances);
    }
}
