<?php

namespace App\Http\Livewire\Rem;

use Livewire\Component;

use App\Models\Rem\RemFile;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UploadRem extends Component
{
    use WithFileUploads;

    public $folder = 'ionline/rem/';
    public $remFile;
    public $file;

    protected $rules = [
        'file'  => 'required'
    ];

    public function mount(RemFile $remFile)
    {
        $this->remFile = $remFile;
    }

    public function lock_unlock()
    {
        $this->remFile->locked = !$this->remFile->locked;
        $this->remFile->save();
        session()->flash('success', 'El Archivo fue Bloqueado/Desbloqueado');
    }

    public function save()
    {
        $this->validate();

        /** Filename ej: 2022-11_cerro_esmeralda(102-701) */
        $filename = $this->remFile->period->format('Y-m').'_';
        $filename .= Str::snake($this->remFile->establishment->name);
        $filename .= '('.$this->remFile->establishment->deis.')';
        $filename .= '.'.$this->file->extension();

        $this->remFile->filename = $this->folder.$filename;
        $this->remFile->save();

        $this->file->storeAs($this->folder, $filename,'gcs');

        session()->flash('success', 'El Archivo fue cargado y subido exitosamente.');
    }

    /**
    * Destroy
    */
    public function deleteFile()
    {
        Storage::disk('gcs')->delete($this->remFile->filename);

        $this->remFile->filename = null;
        $this->remFile->save();

        $this->file = null;

        session()->flash('success', 'el Archivo fue eliminado exitosamente');
    }

    public function render()
    {
        return view('livewire.rem.upload-rem');
    }
}