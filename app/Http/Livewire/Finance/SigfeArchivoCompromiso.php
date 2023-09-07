<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Finance\Dte;
use Illuminate\Support\Facades\Storage;

class SigfeArchivoCompromiso extends Component
{

    use WithFileUploads;

    public $dteId;
    public $file;
    public $successMessage = '';
    public $folder = 'ionline/finances/sigfe/compromiso';
    public $archivoCompromiso = null; 

    public function mount($dteId)
    {
        $this->dteId = $dteId;
        $dte = Dte::find($this->dteId);
        if ($dte) {
            $this->archivoCompromiso = $dte->archivo_compromiso_sigfe;
        }
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

        $dte = Dte::find($this->dteId);
        if ($dte && $this->file) {
            $filename = $this->file->getClientOriginalName(); 
            $filePath = $this->file->storeAs($this->folder, $filename, 'gcs');
            $dte->archivo_compromiso_sigfe = $filePath;
            $dte->save();
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
        $dte = Dte::find($this->dteId);
        if ($dte) {
            $dte->archivo_compromiso_sigfe = null;
            $dte->save();
            $this->successMessage = 'Archivo eliminado exitosamente.';
        }
    }
}
