<?php

namespace App\Livewire\Finance;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\File;
use App\Models\Finance\Dte;
use Illuminate\Support\Facades\Storage;

class ListPdf extends Component
{
    // public $dte;
    public $dteId;
    public $fileId;
    public $fileName;
    public $file;

    public function mount(){
        $this->fileId = $this->file->id;
        $this->fileName = $this->filenameTrim($this->file->name);
    }

    #[On('refreshComponent')]
    public function refreshComponent(){
        $this->fileId = null;
    }

    public function deletePdfNoApproval()
    {
        // unset($this->dte->filesPdf['id'][$fileId]);
        // dd($this->dte->filesPdf);
        if(Storage::disk('gcs')->exists($this->file->storage_path))
        {
            Storage::disk('gcs')->delete($this->file->storage_path);
        }
        $this->file->delete();
        $this->fileId= null;
        // $this->dispatch('pdfRefresh');

    }

    public function downloadPdfNoApproval()
    {

        if(Storage::disk('gcs')->exists($this->file->storage_path))
        {
            return Storage::disk('gcs')->response($this->file->storage_path, mb_convert_encoding($this->file->name,'ASCII'));
        }
        else
        {
            //logger('No se encontró el archivo '.$file->file);
            session()->flash('danger', 'No se encontró el archivo '.$this->file->name);
            return redirect()->route('documents.partes.index');
        }
    }

    public function filenameTrim($fileName)
    {
        $fileNameLenght = 16;
        $fileName = (strlen($fileName) > $fileNameLenght)?substr($fileName, 0, $fileNameLenght).'...':$fileName;
        return $fileName;
    }

    public function render()
    {
        return view('livewire.finance.list-pdf');
    }
}
