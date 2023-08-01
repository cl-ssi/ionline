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

    public $selectedEstablishments;

    public $establishments;

    public $dtes;


    public function refresh()
    {
        
        $this->dtes = Dte::
        //search($this->filter)
            /** Esto me proboca que no pueda utilizar la relación requestForm */
            // ->with([
            //     'immediatePurchase',
            //     'immediatePurchase.purchasingProcessDetail',
            //     'immediatePurchase.purchasingProcessDetail.itemRequestForm',
            //     'immediatePurchase.purchasingProcessDetail.itemRequestForm.requestForm',
            //     'immediatePurchase.purchasingProcessDetail.itemRequestForm.requestForm.contractManager',
            // ])            
            whereNot('tipo_documento', 'guias_despacho')
            ->orderBy('emision')
            ->get();
            //dd($this->dtes);
    }

    public function mount()
    {
        $this->establishments = Establishment::orderBy('name')->get();
        
        //$this->dtes = Dte::whereNot('tipo_documento', 'guias_despacho')->orderBy('emision')->get();

        $this->dtes = Dte::whereNot('tipo_documento', 'guias_despacho')->orderBy('emision')->latest()->take(5)->get();

        //dd($this->dtes);

    }

    public function saveEstablishment($dteId)
    {
        $dte = Dte::find($dteId);

        if ($dte) {
            $dte->establishment_id = $this->selectedEstablishment;
            $dte->save();
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

    public function render()
    {
        // $query = Dte::search($this->filter)
        //     /** Esto me proboca que no pueda utilizar la relación requestForm */
        //     // ->with([
        //     //     'immediatePurchase',
        //     //     'immediatePurchase.purchasingProcessDetail',
        //     //     'immediatePurchase.purchasingProcessDetail.itemRequestForm',
        //     //     'immediatePurchase.purchasingProcessDetail.itemRequestForm.requestForm',
        //     //     'immediatePurchase.purchasingProcessDetail.itemRequestForm.requestForm.contractManager',
        //     // ])            
        //     ->whereNot('tipo_documento', 'guias_despacho')
        //     ->orderBy('emision')
        //     ->paginate(50);

        

        return view('livewire.finance.index-dtes');
    }
}
