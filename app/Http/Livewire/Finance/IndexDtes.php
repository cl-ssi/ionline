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

    public $selectedCenabasts = [];

    public $establishments;

    public $establishment;

    public $successMessages = [];

    public $successCenabasts = [];



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


    public function toggleCenabast($dteId)
    {
        $dte = Dte::find($dteId);

        if ($dte) {
            if ($dte->cenabast == 0) {
                $dte->cenabast = 1;
                $this->selectedCenabasts[$dteId] = true;
            } else {                
                $dte->cenabast = 0;
                unset($this->selectedCenabasts[$dteId]);
            }

            $dte->save();
        }
    }




    public function saveEstablishment($dteId)
    {
        $dte = Dte::find($dteId);
        if ($dte) {
            $dte->establishment_id = $this->selectedEstablishments[$dteId];
            $dte->save();
            $this->successMessages[$dteId] = 'El establecimiento fue asignado exitosamente al DTE';
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
        $query = Dte::search($this->filter)->with([
            'purchaseOrder',
            'controls',
            'requestForm',
            'requestForm.contractManager',
        ])
            ->whereNot('tipo_documento', 'guias_despacho')
            ->orderBy('emision')
            ->paginate(50);

        $establishments = Establishment::orderBy('name')->get();

        // Actualizar la propiedad selectedCenabasts para marcar los checkboxes
        $this->selectedCenabasts = [];
        foreach ($query as $dte) {
            if ($dte->cenabast == 1) {
                $this->selectedCenabasts[$dte->id] = true;
            }
        }


        return view('livewire.finance.index-dtes', [
            'dtes' => $query,
            'establishments' => $establishments,
        ]);
    }
}
