<?php

namespace App\Http\Livewire\Finance;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\Dte;

class IndexDtes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filter;

    public $showManualDTE = false;


    public function refresh()
    {
        /**
         * Sólo hace el re redner del componente
         */
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
            ->whereNull('folio_sigfe')
            ->whereNot('tipo_documento', 'guias_despacho')
            ->orderBy('emision')
            ->paginate(50);

        return view('livewire.finance.index-dtes', [
            'dtes' => $query
        ]);
    }

}
