<?php

namespace App\Livewire\Rem;

use App\Models\Rem\RemFile;
use Livewire\Component;
use Illuminate\Support\Str;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class NewUploadRem extends Component
{

    use WithFileUploads;

    public $folder = 'ionline/rem/';
    public $folderOriginal = 'ionline/rem/original/';
    public $folderCorreccion = 'ionline/rem/correccion/';
    public $remFile;
    public $remFileNew;
    public $file;
    public $remEstablishment;
    public $period;
    public $rem_period_series_id;
    public $rem_period_series;
    public $serie;
    public $type = null;
    public $hasFile = false;
    public $isOriginal = false;
    public $isCorreccion = false;
    public $isAutorizacion = false;
    public $monthsToShow;

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
        $remFiles = RemFile::where('rem_period_series_id', $this->rem_period_series->id)->where('establishment_id', $this->remEstablishment->establishment->id)->where('type', $this->type)->get();

        // Asignar el resultado a una propiedad del componente Livewire
        $this->remFiles = $remFiles;


        // Establecer la variable $hasFile en true si hay al menos un registro en la colección
        $this->hasFile = $remFiles->count() > 0;
        $this->isOriginal = $remFiles->where('type', 'Original')->count() > 0;
        $this->isCorreccion = $remFiles->where('type', 'Correccion')->count() > 0;
        $this->isAutorizacion = $remFiles->where('type', 'Autorizacion')->count() > 0;
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
        session()->flash('success', 'El Archivo ha sido Borrado de manera exitosa');
        return redirect()->route('rem.files.rem_original', ['monthsToShow' => $this->monthsToShow]);
    }


    public function lock_unlock()
    {
        $this->remFiles->first()->locked = !$this->remFiles->first()->locked;
        $this->remFiles->first()->save();
        session()->flash('success', 'El Archivo ha sido bloqueado/desbloqueado de manera exitosa');
        return redirect()->route('rem.files.rem_original', ['monthsToShow' => $this->monthsToShow]);
        //return redirect()->route('rem.files.rem_original');
    }


    public function save()
    {

        $this->validate();
        if ($this->type == 'Original') {
            $this->folder = $this->folderOriginal;
        } else {
            $this->folder = $this->folderCorreccion;
        }
        // // Creación del archivo con formato según cometado por chicos de estadisticas, se guardará en diferentes carpetas ya que quieren tener el mismo nombre
        $filename = $this->remEstablishment->establishment->new_deis_without_first_character;
        $filename .= strtoupper($this->rem_period_series->serie->name);        
        $filename .= $this->rem_period_series->period->month_string;
        $extension = pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filename .= '.' . $extension;
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
        if ($this->type == 'Original') {
            session()->flash('success', 'Archivo de REM Subido Exitosamente');
            //return redirect()->route('rem.files.rem_original');
            return redirect()->route('rem.files.rem_original', ['monthsToShow' => $this->monthsToShow]);
            
        } elseif ($this->type == 'Correccion') {

            session()->flash('success', 'Archivo de Correccion de REM subido exitosamente');
            return redirect()->route('rem.files.rem_correccion');
        }
    }
}
