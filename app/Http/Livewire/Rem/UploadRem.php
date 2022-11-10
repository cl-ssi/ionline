<?php

namespace App\Http\Livewire\Rem;

use Livewire\Component;

use App\Models\Rem\RemFile;
use App\Establishment;
use Livewire\WithFileUploads;



class UploadRem extends Component
{
    use WithFileUploads;

    public $name = "probando";
    public $month;
    public $year;
    public $establishment;
    public $rem_file;
    public $folder = 'ionline/rem/';
    public $file;


    public function mount($year, $month, Establishment $establishment)
    {
        $this->year = $year;
        $this->month = $month;
        $this->establishment = $establishment;

        $this->rem_file = RemFile::where('establishment_id', $establishment->id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();
    }

    public function lock_unlock()
    {
        $this->rem_file->is_locked=!$this->rem_file->is_locked;
        $this->rem_file->save();
        session()->flash('success', 'El Archivo fue Bloqueado/Desbloqueado');
        return redirect()->route('rem.files.index');

    }

    public function save()
    {       
        //dd($this->file);
        $file_internal_format = $this->year.'-'.$this->month.'-'.$this->establishment->name.'('.$this->establishment->deis.')';
        $this->rem_file = RemFile::Create([            
            'month' =>  $this->month,
            'year'  =>  $this->year,
            'establishment_id'  =>  $this->establishment->id,
            'filename'  =>  $this->folder.$file_internal_format.'.'.$this->file->extension(),
        ]);

        $this->file->storeAs(
            $this->folder, 
            $file_internal_format.'.'.$this->file->extension(),
            'gcs'
        );


        session()->flash('success', 'El Archivo fue cargado y subido exitosamente.');
        return redirect()->route('rem.files.index');
    }

    public function render()
    {
        return view('livewire.rem.upload-rem');
    }
}