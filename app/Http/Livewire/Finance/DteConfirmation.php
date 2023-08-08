<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Finance\File;
use App\Models\RequestForms\PaymentDoc;

class DteConfirmation extends Component
{
    public $dte;
    public $confirmation_observation;
    public $files = []; // Arreglo para almacenar archivos temporales
    public $storage_path = '/ionline/finances/dte/files';

    /**
     * Mount
     */
    public function mount(Dte $dte)
    {
        $this->dte = $dte;
    }

    public function uploadFile($paymentDocId)
    {
        
        if (isset($this->files[$paymentDocId])) {
            $paymentDoc = PaymentDoc::find($paymentDocId);

            if ($paymentDoc) {
                $file = $this->files[$paymentDocId];
                $filename = $file->getClientOriginalName();
                $filePath = $file->storeAs($this->storage_path.
                    $paymentDoc->name, $filename, ['disk' => 'gcs']);
                
                File::create([
                    'file' => $filePath,
                    'name' => $filename,
                    'payment_doc_id' => $paymentDocId,
                    'dte_id' => $this->dte->id,
                    'request_form_id' => 8,
                ]);
                
            }
        }
    }


    public function render()
    {
        // $this->dte->fresh();
        // $this->dte->requestForm->contractManager;
        return view('livewire.finance.dte-confirmation');
    }
}
