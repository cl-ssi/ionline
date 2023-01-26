<?php

namespace App\Http\Livewire\Warehouse\Invoices;

use App\Http\Requests\RequestForm\StoreInvoiceRequest;
use App\Models\RequestForms\Invoice;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\Store;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceManagement extends Component
{
    use WithFileUploads;

    public $store;

    public $controls;
    public $number;
    public $date;
    public $amount;
    public $file;
    public $iteration;
    public $search;
    public $selected_controls;
    public $folder = 'ionline/invoices/';

    public function mount(Store $store)
    {
        $this->iteration = 1;
        $this->selected_controls = [];
        $this->controls = collect([]);
    }

    public function rules()
    {
        return (new StoreInvoiceRequest())->rules();
    }

    public function render()
    {
        return view('livewire.warehouse.invoices.invoice-management');
    }

    public function searchPurchaseOrder()
    {
        $this->selected_controls = [];
        $controls = collect([]);

        if($this->search)
        {
            $controls = Control::query()
                ->whereStoreId($this->store->id)
                ->whereType(1)
                ->wherePoCode($this->search)
                ->get();
        }

        $this->controls = $controls;
    }

    public function save()
    {
        $dataValidated = $this->validate();
        $invoice = Invoice::create($dataValidated);
        $filename = 'invoice-' . $invoice->number . '-date-' . $invoice->date->format('Y-m-d');
        $url = $filename.'.pdf';

        $this->file->storeAs($this->folder, $url, 'gcs');

        $invoice->update([
            'url' => Storage::url($this->folder . $url)
        ]);

        $controls = Control::whereIn('id', $this->selected_controls)->get();

        foreach($controls as $control)
        {
            $control->invoices()->save($invoice);
        }

        $this->reset([
            'number',
            'date',
            'amount',
            'file',
            'search',
        ]);

        $this->iteration++;
        $this->selected_controls = [];
        $this->controls = collect([]);
    }
}
