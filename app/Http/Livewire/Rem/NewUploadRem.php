<?php

namespace App\Http\Livewire\Rem;

use App\Models\Rem\RemFile;
use Livewire\Component;
use Illuminate\Support\Str;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class NewUploadRem extends Component
{

    use WithFileUploads;

    public $folder = 'ionline/rem/';
    public $remFile;
    public $remFileNew;
    public $file;
    public $remEstablishment;
    public $period;
    public $rem_period_series_id;
    public $rem_period_series;
    public $serie;
    public $type;
    public $hasFile = false;

    protected $rules = [
        'file'  => 'required'
    ];


    public function render()
    {
        return view('livewire.rem.new-upload-rem');
    }

    public function mount(RemFile $remFiles)
    {
        // Filtrar los registros que deseas obtener
        $remFiles = RemFile::where('rem_period_series_id', $this->rem_period_series->id)->where('establishment_id', $this->remEstablishment->establishment->id)->get();

        // Asignar el resultado a una propiedad del componente Livewire
        $this->remFiles = $remFiles;


        // Establecer la variable $hasFile en true si hay al menos un registro en la colección
        $this->hasFile = $remFiles->count() > 0;
    }

    public function download()
    {

        if ($this->remFiles && is_object($this->remFiles->first())) {
            return Storage::disk('gcs')->download($this->remFiles->first()->filename);
        }
    }

    public function deleteFile()
    {
        Storage::disk('gcs')->delete($this->remFiles->first()->filename);

        $this->remFiles->first()->filename = null;
        $this->remFiles->first()->save();
        $this->file = null;
        return redirect()->route('rem.files.rem_original');
    }


    public function lock_unlock()
    {
        $this->remFiles->first()->locked = !$this->remFiles->first()->locked;
        $this->remFiles->first()->save();
        return redirect()->route('rem.files.rem_original');
    }


    public function save()
    {
        // // Creación del archivo con formato personalizado ej: 2022-11_cerro_esmeralda(102-701)_B.pdf */
        $filename = $this->period->period->format('Y-m') . '_';
        $filename .= Str::snake($this->remEstablishment->establishment->name);
        $filename .= '(' . $this->remEstablishment->establishment->deis . ')_';
        $filename .= $this->rem_period_series->serie->name;
        $filename .= '_' . $this->type;
        $filename .= '.' . $this->file->extension();

        $this->remFileNew = RemFile::updateOrCreate(
            [
                'period' => $this->period->period,
                'rem_period_series_id' => $this->rem_period_series->id,
                'establishment_id' => $this->remEstablishment->establishment->id,
                'type' => $this->type

            ],
            [

                'filename' => $this->folder . $filename,

            ]
        );

        $this->remFileNew->save();
        $this->file->storeAs($this->folder, $filename, 'gcs');

        // Establece la variable $hasFile en true
        $this->hasFile = true;


        // Redirigir a la misma página en la que se encuentra el componente
        if ($this->type=='Original') {
            session()->flash('success', 'Archivo de REM Subido Exitosamente');
            return redirect()->route('rem.files.rem_original');
        } elseif ($this->type=='Correccion') {
            
            session()->flash('success', 'Archivo de Correccion de REM subido exitosamente');
            return redirect()->route('rem.files.rem_correccion');
        }
    }
}
