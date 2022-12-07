<?php

namespace App\Http\Livewire\Rem;

use App\Models\Rem\RemFile;
use Livewire\Component;
use Illuminate\Support\Str;

use Livewire\WithFileUploads;

class NewUploadRem extends Component
{

    use WithFileUploads;

    public $folder = 'ionline/rem/';
    public $remFile;
    public $file;
    public $remEstablishment;
    public $period;
    public $rem_period_series_id;
    public $rem_period_series;
    public $serie;

    protected $rules = [
        'file'  => 'required'
    ];


    public function render(RemFile $remFile)
    {
        $this->remFile = $remFile;
        return view('livewire.rem.new-upload-rem');
    }


    public function save()
    {
        $this->validate();

        /** Filename ej: 2022-11_cerro_esmeralda(102-701).pdf */
        // $filename = $this->remFile->period->format('Y-m').'_';
        // $filename .= Str::snake($this->remFile->establishment->name);
        // $filename .= '('.$this->remFile->establishment->deis.')';
        // $filename .= '.'.$this->file->extension();

        // $this->remFile->filename = $this->folder.$filename;

        
        // Creación del archivo con formato personalizado ej: 2022-11_cerro_esmeralda(102-701)_B.pdf */
        $filename = $this->period->period->format('Y-m').'_';
        $filename .= Str::snake($this->remEstablishment->establishment->name);
        $filename .= '('.$this->remEstablishment->establishment->deis.')_';
        $filename .= $this->rem_period_series->serie->name;
        $filename .= '.'.$this->file->extension();



        $this->remFile->period =  $this->period->period;
        $this->remFile->establishment_id =$this->remEstablishment->establishment->id;
        $this->remFile->filename = $this->folder.$filename;
        $this->remFile->rem_period_series_id = $this->rem_period_series->id;
        $this->remFile->save();

        $this->file->storeAs($this->folder, $filename,'gcs');
        session()->flash('info', 'Se guardo correctamente el archivo');
    }



}
