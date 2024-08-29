<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SigfeArchivoCompromiso extends Component
{

    use WithFileUploads;

    public $dte;
    public $file;
    public $successMessage = '';
    public $folder = 'ionline/finances/sigfe/compromiso';
    public $archivoCompromiso = null;
    public $onlyRead = false;


    public function mount($dte)
    {
        $this->dte = $dte;
        $this->archivoCompromiso = $dte->archivo_compromiso_sigfe;
    }

    public function render()
    {
        return view('livewire.finance.sigfe-archivo-compromiso');
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|mimes:pdf', // Change the allowed file types as needed
        ]);
        if ($this->dte && $this->file) {
            $filename = $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs($this->folder, $filename, 'gcs');
            $this->dte->archivo_compromiso_sigfe = $filePath;
            $this->dte->save();
            $this->successMessage = 'Archivo Compromiso Sigfe subido exitosamente.';
        }
        
    }

    public function downloadFile($filename)
    {
        return Storage::disk('gcs')->download($filename);
    }

    public function deleteFile($filename)
    {
        Storage::disk('gcs')->delete($filename);
        if ($this->dte) {
            $this->dte->archivo_compromiso_sigfe = null;
            $this->dte->save();
            $this->successMessage = 'Archivo eliminado exitosamente.';
        }
    }
}
