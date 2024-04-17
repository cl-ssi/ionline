<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Finance\AccountingCode;

class AccountingUpdate extends Component
{
    public $oc;
    public $establishment;
    public $accountingCodes;
    


    public function mount()
    {     
        $this->establishment = auth()->user()->organizationalUnit->establishment;
        $this->accountingCodes = AccountingCode::all();
    }

    



    public function render()
    {
        return view('livewire.inventory.accounting-update', [
            'inventories' => $this->getInventories(),
        ]);
    }

    public function getInventories()
    {
        
        if ($this->oc) {
            
            return Inventory::query()
                ->with([
                    'product',
                    'place',
                    'place.location',
                    'responsible',
                    'using',
                    'unspscProduct',
                    'lastMovement',
                    'lastMovement.responsibleUser',
                    'lastMovement.usingUser',
                ])
                ->where('po_code', 'LIKE', '%' . $this->oc . '%')
                ->orderByDesc('id')
                ->get();
        } else {
            // Si no se proporcionó un número de folio de OC, devolver una colección vacía
            return collect();
        }
    }

    public function search()
    {
        $this->inventories = $this->getInventories();
    }


}
