<?php

namespace App\Http\Livewire\Invoice;

use App\Models\ServiceRequests\Fulfillment;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $invoiceFile;
    public $fulfillmentId;
    public $hasInvoiceFile;

    public function save()
    {
        $this->validate([
            'invoiceFile' => 'required|mimes:pdf|max:10240', // 10MB Max
        ]);

        $this->invoiceFile->storeAs('invoices', $this->fulfillmentId.'.pdf');

        $fulfillment = Fulfillment::find($this->fulfillmentId);
        $fulfillment->has_invoice_file = true;
        $fulfillment->save();
        $this->hasInvoiceFile = true;
    }

    public function render()
    {
        return view('livewire.invoice.upload');
    }
}
