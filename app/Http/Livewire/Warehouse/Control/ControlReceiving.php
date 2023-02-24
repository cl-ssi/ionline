<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\Control;
use App\Services\SignatureService;
use Livewire\Component;
use Livewire\WithPagination;

class ControlReceiving extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $store;
    public $type;
    public $nav;

    public function render()
    {
        return view('livewire.warehouse.control.control-receiving', [
            'controls' => $this->getControls()
        ]);
    }

    public function getControls()
    {
        $controls = Control::query()
            ->whereStoreId($this->store->id)
            ->whereType(1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $controls;
    }

    public function sendTechnicalRequest(Control $control)
    {
        $technicalSigner = $control->technicalSigner ?? null;

        if($technicalSigner)
        {
            $technicalSignature = new SignatureService();
            $technicalSignature->addResponsible($this->store->visator);
            $technicalSignature->addSignature(
                10,
                "Acta de Recepción Técnica #$control->id",
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

            session()->flash('success', "La solicitud de firma fue enviada a $technicalSigner->tinny_name.");
        }
    }
}
