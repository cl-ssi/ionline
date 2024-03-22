<?php

namespace App\Http\Livewire\PurchasePlan;

use Livewire\Component;

use App\User;
use App\Models\Parameters\Parameter;

class AssignPurchasePlan extends Component
{
    public $purchasePlan;
    public $purchasers;

    public function render()
    {
        $estab_others = $this->purchasePlan->organizationalUnit->establishment_id;
        $ouSearch = Parameter::get('Abastecimiento','purchaser_ou_id', $estab_others);
        
        $this->purchasers = User::permission('Request Forms: purchaser')
            ->whereHas('organizationalUnit', fn($q) => $q->where('establishment_id', $estab_others))
            ->OrWhere('organizational_unit_id', $ouSearch)
            ->orderBy('name','asc')
            ->get();

        return view('livewire.purchase-plan.assign-purchase-plan');
    }
}
