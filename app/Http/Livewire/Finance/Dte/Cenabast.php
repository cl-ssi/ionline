<?php

namespace App\Http\Livewire\Finance\Dte;

use App\Models\Establishment;
use App\Models\Finance\Dte;
use App\Models\Finance\PurchaseOrder\Prefix;
use Livewire\Component;
use Livewire\WithPagination;

class Cenabast extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment_id = null;
    public $folio_oc = null;
    public $folio = null;
    public $without_reception = false;

    public $contract_manager_id = null;
    public $without_contract_manager = false;

    protected $listeners = ['userSelected'];

    public function search()
    {
        $this->resetPage();
    }

    public function userSelected($user)
    {
        $this->contract_manager_id = $user;
    }

    public function setContractManager(Dte $dte) {
        $dte->contract_manager_id = $this->contract_manager_id;
        // $dte->refresh();
        $dte->establishment_id = $dte->contractManager->organizationalUnit->establishment_id;
        $dte->save();
    }

    public function render()
    {
        // Obtener todos los establecimientos para el filtro
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));
        
        $establishments = Establishment::whereIn('id',$establishments_ids)->orderBy('official_name')->get();

        // Obtener todos los prefijos de Prefix donde cenabast sea verdadero
        $prefixes = Prefix::where('cenabast', true)->pluck('prefix')->toArray();

        // Realizar la consulta para obtener todas las DTEs con folio_oc que comience por cualquiera de los prefijos
        $dtes = Dte::with([
                'establishment',  // eager loading para evitar N+1
                'purchaseOrder',
                'purchaseOrder.receptions',
                'contractManager'
            ])
            ->where(function ($query) use ($prefixes) {
                foreach ($prefixes as $prefix) {
                    $query->orWhere('folio_oc', 'like', "$prefix%");
                }
            })
            ->when($this->establishment_id, function ($query, $establishment_id) {
                if($this->establishment_id == 'Sin') {
                    $query->whereNull('establishment_id');
                }
                else {
                    $query->where('establishment_id', $establishment_id);
                }
            })
            ->when($this->folio_oc, function ($query, $folio_oc) {
                $query->where('folio_oc', $folio_oc);
            })
            ->when($this->folio, function ($query, $folio) {
                $query->where('folio', $folio);
            })
            ->when($this->without_reception, function ($query, $without_reception) {
                $query->whereDoesntHave('purchaseOrder.receptions');
            })
            ->when($this->without_contract_manager, function ($query, $without_contract_manager) {
                $query->whereNull('contract_manager_id');
            })
            ->orderBy('id', 'desc')
            ->paginate(100);

        return view('livewire.finance.dte.cenabast', compact('dtes', 'establishments'));
    }
}
