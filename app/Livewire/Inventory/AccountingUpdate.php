<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Finance\AccountingCode;

class AccountingUpdate extends Component
{
    public $oc;
    public $establishment;
    public $allAccountingCodes;
    public $usefulLife = [];
    public $poPrice = [];
    public $accountingCodes = [];
    public $total = 0;    
    
    


    public function mount()
    {     
        $this->establishment = auth()->user()->organizationalUnit->establishment;
        $this->allAccountingCodes = AccountingCode::all();
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
            // Obtener los inventarios
            $inventories = Inventory::query()
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

            $this->usefulLife = [];
            $this->poPrice = [];
            $this->accountingCodes = [];
            $this->total = $inventories->sum('po_price');
            
            foreach ($inventories as $inventory) {
                foreach ($inventories as $inventory) {
                    $this->usefulLife[$inventory->id] = $inventory->useful_life;
                    $this->poPrice[$inventory->id] = $inventory->po_price;
                    $this->accountingCodes[$inventory->id] = $inventory->accounting_code_id;
                    
                }
                
            }
    
            // Devolver los inventarios con los valores asignados
            return $inventories;
        } else {
            // Si no se proporcionó un número de folio de OC, devolver una colección vacía
            return collect();
        }
    }
    
    

    public function search()
    {
        $this->inventories = $this->getInventories();
    }

    public function updateAccountingCode($inventoryId, $accountId)
    {
        $this->accountingCodes[$inventoryId] = $accountId;
    }


    public function update()
    {
        foreach ($this->inventories as $inventory) {
            if (isset($this->usefulLife[$inventory->id]) || isset($this->poPrice[$inventory->id]) || isset($this->accountingCodes[$inventory->id])) {
                $updateData = [];
    
                if (isset($this->usefulLife[$inventory->id])) {
                    $updateData['useful_life'] = $this->usefulLife[$inventory->id];
                }
    
                if (isset($this->poPrice[$inventory->id])) {
                    $updateData['po_price'] = $this->poPrice[$inventory->id];
                }
    
                if (isset($this->accountingCodes[$inventory->id])) {
                    $updateData['accounting_code_id'] = $this->accountingCodes[$inventory->id];

                }
    
                if (!empty($updateData)) {
                    $inventory->update($updateData);
                }
            }
        }
    
        // Actualizar la lista de inventarios después de la actualización
        //$this->inventories = $this->getInventories();
        $this->mount();
        session()->flash('success', '¡Los inventarios se actualizaron correctamente!');
    }
    



}
