<?php

namespace App\Http\Livewire\Finance;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Establishment;

class IndexDtes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filter;

    public $showManualDTE = false;

    public $selectedEstablishments = [];

    public $establishments;

    public $establishment;

    protected $rules = [
        'selectedEstablishments' => 'required'
    ];


    public function refresh()
    {
        /**
         * Sólo hace el re redner del componente
         */
    }



    public function mount()
    {
        $this->establishments = Establishment::orderBy('name')->get();
        $this->selectedEstablishments = []; // Inicializar el array vacío

    }

    public function saveEstablishment($dteId)
    {
        $dte = Dte::find($dteId);

        if ($dte) {
            $dte->establishment_id = $this->selectedEstablishments[$dteId];
            $dte->save();
            session()->flash('success', 'El establecimiento fue asignado exitosamente al DTE');
            return redirect()->route('finance.dtes.index');
            
        }
    }


    public function loadManualDTE()
    {
        $this->showManualDTE = true;
    }

    public function dteAdded()
    {
        // Ocultar el formulario
        $this->showManualDTE = false;
    }

    public function updateSelectedEstablishment($dteId, $establishmentId)
    {
        $this->selectedEstablishments[$dteId] = $establishmentId;
    }

    public function render()
    {
        $query = Dte::search($this->filter)
            /** Esto me proboca que no pueda utilizar la relación requestForm */
            // ->with([
            //     'immediatePurchase',
            //     'immediatePurchase.purchasingProcessDetail',
            //     'immediatePurchase.purchasingProcessDetail.itemRequestForm',
            //     'immediatePurchase.purchasingProcessDetail.itemRequestForm.requestForm',
            //     'immediatePurchase.purchasingProcessDetail.itemRequestForm.requestForm.contractManager',
            // ])            
            ->whereNot('tipo_documento', 'guias_despacho')
            ->orderBy('emision')
            ->paginate(50);

        $establishments = Establishment::orderBy('name')->get();


        return view('livewire.finance.index-dtes', [
            'dtes' => $query,
            'establishments' => $establishments,
        ]);
    }
}
