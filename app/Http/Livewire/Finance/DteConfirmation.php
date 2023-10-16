<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Finance\File;
use App\Models\RequestForms\PaymentDoc;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class DteConfirmation extends Component
{
    use WithFileUploads;
    public $dte;
    public $paymentDocs;
    public $confirmation_observation;
    public $files = []; // Arreglo para almacenar archivos temporales
    public $existingFiles = []; // Existing files associated with DTE
    public $storage_path = '/ionline/finances/dte/files/';
    public $uploadSuccess = false;

    /**
     * Mount
     */
    public function mount(Dte $dte)
    {
        $this->dte = $dte;
        $this->paymentDocs = $dte->requestForm->paymentDocs;
        $this->existingFiles = $dte->files;
    }

    /**
    * Confirmation
    */
    public function saveConfirmation($status)
    {
        $this->dte->confirmation_status = $status;
        $this->dte->confirmation_user_id = auth()->id();
        $this->dte->confirmation_ou_id = auth()->user()->organizational_unit_id;
        $this->dte->confirmation_observation = $this->confirmation_observation;
        $this->dte->confirmation_at = now();
        $this->dte->save();
    }

    public function downloadFile($fileId)
    {
        $file = File::findOrFail($fileId);
        return Storage::disk('gcs')->download($file->file);
    }

    public function setUploadSuccess()
    {
        $this->uploadSuccess = true;
    }

    public function uploadFile($paymentDocId)
    {

        if (isset($this->files[$paymentDocId])) {
            $paymentDoc = PaymentDoc::find($paymentDocId);
            if ($paymentDoc) {
                $file = $this->files[$paymentDocId];
                $filename = $file->getClientOriginalName();
                $filePath = $file->storeAs($this->storage_path, $filename, ['disk' => 'gcs']);
                File::create([
                    'file' => $filePath,
                    'name' => $filename,
                    'payment_doc_id' => $paymentDocId,
                    'dte_id' => $this->dte->id,
                    'request_form_id' => $paymentDoc->request_form_id,
                ]);
                $this->setUploadSuccess();
            }
        }
    }


    public function render()
    {
        return view('livewire.finance.dte-confirmation')->extends('layouts.bt4.app');
    }

    public function rejectedDte()
    {
        $this->dte->update([
            'confirmation_status' => 0,
            'confirmation_user_id' => auth()->id(),
            'confirmation_ou_id' => auth()->user()->organizational_unit_id,
            'confirmation_observation' => $this->confirmation_observation,
            'confirmation_at' => now(),
        ]);

        session()->flash('success', 'El DTE fue rechazado.');
    }
}
