<?php

namespace App\Http\Livewire\Rem;

use Livewire\Component;

use App\Models\Rem\RemFile;
use Livewire\WithFileUploads;


class UploadRem extends Component
{
    use WithFileUploads;
    
    public $rem_files;
    public $name="probando";
    public $month;
    public $year;
    public $establishment_id;



    public function save()
    {
        
        //$rem_files->save();

        $remFiles  =   RemFile::Create([
            'name'    =>  $this->name,
            'month'    =>  $this->month,
             'year'       =>  $this->year,
             'establishment_id'       =>  $this->establishment_id,
             ]);
        session()->flash('success', 'El Archivo fue cargado y subido exitosamente.');
        return redirect()->route('rem.files.index');
        
    }

    public function render()
    {
        return view('livewire.rem.upload-rem');
    }
}
