<?php

namespace App\Http\Livewire\PurchasePlan;

use Livewire\Component;
use App\Models\PurchasePlan\PurchasePlan;
use Livewire\WithPagination;

class SearchPurchasePlan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $index;

    public function render()
    {
        if($this->index == 'own'){
            //MIS PLANES DE COMPRAS INDEX 
            return view('livewire.purchase-plan.search-purchase-plan', [
                'purchasePlans' => PurchasePlan::latest()
                    /*
                    ->where('user_allowance_id', Auth::user()->id)
                    ->orWhere('creator_user_id', Auth::user()->id)
                    ->orWhere('organizational_unit_allowance_id', Auth::user()->organizationalUnit->id)
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance)
                    */
                    ->paginate(50)
                ]
            );
        }
    }
}
