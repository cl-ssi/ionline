<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SigfeArchivoComprobante extends Component
{

    use WithFileUploads;
    


    public $dte;
    public $file;
    public $successMessage = '';
    public $folder = 'ionline/finances/sigfe/comprobante';
    public $archivoComprobante = null;


    public function mount($dte)
    {
        $this->dte = $dte;
        $this->archivoComprobante = $dte->archivo_comprobante_pago_sigfe;
    }


    public function render()
    {
        return view('livewire.finance.sigfe-archivo-comprobante');
    }


    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|mimes:pdf', // Change the allowed file types as needed
        ]);
        if ($this->dte && $this->file) {
            $filename = $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs($this->folder, $filename, 'gcs');
            $this->dte->archivo_comprobante_pago_sigfe = $filePath;
            $this->dte->save();
            $this->successMessage = 'Archivo Comprobante Liquidación de fondos subido exitosamente.';
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
            $this->dte->archivo_comprobante_sigfe = null;
            $this->dte->save();
            $this->successMessage = 'Archivo eliminado exitosamente.';
        }
    }


}
