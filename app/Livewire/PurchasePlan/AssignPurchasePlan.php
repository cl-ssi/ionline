<?php

namespace App\Livewire\PurchasePlan;

use Livewire\Component;

use App\Models\User;
use App\Models\Parameters\Parameter;

class AssignPurchasePlan extends Component
{
    public $purchasePlan;
    public $purchasers;

    public $assignUserId;

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

    public function save(){
        $this->purchasePlan->assign_user_id = $this->assignUserId;
        $this->purchasePlan->save();

        session()->flash('success', 'Estimados Usuario, se ha asignado exitosamente el Plan de Compra N°'.$this->purchasePlan->id);
        return redirect()->route('purchase_plan.assign_purchaser_index');
    }
}
