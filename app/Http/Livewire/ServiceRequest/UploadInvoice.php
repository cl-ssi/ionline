<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceRequests\Fulfillment;
use Illuminate\Support\Facades\Storage;

class UploadInvoice extends Component
{
    use WithFileUploads;

    public $invoiceFile;
    public $fulfillment;
    public $storage_path = '/ionline/service_request/invoices/';

    public function save()
    {
        $this->validate([
            'invoiceFile' => 'required|mimes:pdf|max:10240', // 10MB Max
        ]);

        $this->invoiceFile->storeAs(
            $this->storage_path, 
            $this->fulfillment->id.'.pdf',
            'gcs'
        );

        $this->fulfillment->update(['has_invoice_file' => true]);
    }

    public function delete() {
        Storage::delete($this->storage_path.$this->fulfillment->id.'.pdf');
        $this->fulfillment->update(['has_invoice_file' => false]);
    }

    public function render()
    {
        return view('livewire.service-request.upload-invoice',
            ['has_invoice_file' => $this->fulfillment->has_invoice_file]);
    }
}
