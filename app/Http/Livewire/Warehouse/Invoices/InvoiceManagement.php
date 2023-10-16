<?php

namespace App\Http\Livewire\Warehouse\Invoices;

use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Services\SignatureService;
use App\Notifications\Warehouse\TechnicalReception;
use App\Models\Warehouse\Store;
use App\Models\Warehouse\Control;
use App\Models\RequestForms\Invoice;
use App\Http\Requests\RequestForm\StoreInvoiceRequest;

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

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount(Store $store)
    {
        $this->iteration = 1;
        $this->selected_controls = [];
        $this->controls = collect([]);

        $this->controls = $this->getControls();
    }

    public function rules()
    {
        return (new StoreInvoiceRequest())->rules();
    }

    public function render()
    {
        return view('livewire.warehouse.invoices.invoice-management')->extends('layouts.bt4.app');
    }

    public function searchPurchaseOrder()
    {
        $this->selected_controls = [];
        $this->controls = $this->getControls();
    }

    public function getControls()
    {
        $controls = Control::query()
            ->whereStoreId($this->store->id)
            ->whereType(1)
            ->whereCompletedInvoices(false)
            ->when($this->search, function ($query) {
                $query->where('po_code', 'like', $this->search);
            })
            ->has('items')
            ->orderByDesc('created_at')
            ->get();

        return $controls;
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
        $this->controls = $this->getControls();
    }

    public function markCompletedInvoices(Control $control)
    {
        $control->update([
            'completed_invoices' => true
        ]);

        $this->controls = $this->getControls();
        $this->sendTechnicalRequestSignature($control);
    }

    public function sendTechnicalRequestSignature(Control $control)
    {
        $technicalSigner = $control->technicalSigner ?? null;

        if($technicalSigner)
        {
            $technicalSignature = new SignatureService();
            $technicalSignature->addResponsible($this->store->visator);

            $subject = "Acta de Recepción Técnica #$control->id";

            $technicalSignature->addSignature(
                10,
                $subject,
                "Recepción #$control->id",
                'Visación en cadena de responsabilidad',
                true
            );
            $technicalSignature->addView('warehouse.pdf.report-reception', [
                'type' => '',
                'control' => $control,
                'store' => $control->store,
                'act_type' => 'reception',
            ]);
            $technicalSignature->addVisators(collect([]));
            $technicalSignature->addSignatures(collect([$technicalSigner]));
            $technicalSignature = $technicalSignature->sendRequest();
            $control->technicalSignature()->associate($technicalSignature);
            $control->save();

            $technicalSigner->notify(new TechnicalReception($subject));

            session()->flash('success', "La solicitud de firma del Ingreso #". $control->id . " fue enviada a $technicalSigner->tinny_name.");
        }
    }
}
