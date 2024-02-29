<?php

namespace App\Http\Livewire\PurchasePlan;

use App\Models\Parameters\Parameter;
use Livewire\Component;
use App\Models\PurchasePlan\PurchasePlan;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SearchPurchasePlan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $index;

    public function delete(PurchasePlan $purchasePlan)
    {
        $purchasePlan->delete();
    }

    public function render()
    {
        $query = PurchasePlan::query()->with('organizationalUnit.establishment', 'approvals.sentToOu', 'userResponsible', 'userCreator')->latest();

        if($this->index == 'own'){
            //PLANES DE COMPRAS: OWN INDEX
            $organizationalUnitIn = array();
            $organizationalUnitIn[] = auth()->user()->organizationalUnit->id;

            if(auth()->user()->organizationalUnit->id == Parameter::get('ou', 'ControlEquipos') || auth()->user()->organizationalUnit->id == Parameter::get('ou', 'ControlInfraestructura')){
                $organizationalUnitIn[] = Parameter::get('ou', 'DeptoRRFF');
            }

            if(auth()->user()->organizationalUnit->id == Parameter::get('ou', 'DeptoAPS')){
                $childs_array = auth()->user()->organizationalUnit->childs->pluck('id')->toArray();
                $organizationalUnitIn = [auth()->user()->organizationalUnit->id, ...$childs_array];
            }

            $purchasePlans = $query
                ->where('user_creator_id', auth()->id())
                ->orWhere('user_responsible_id', auth()->id())
                ->orWhereIn('organizational_unit_id', $organizationalUnitIn)
                ->when(auth()->user()->organizationalUnit->id == Parameter::get('ou', 'SaludMentalSSI'),
                    fn($q) => $q->orwhereHas('organizationalUnit', 
                        fn($q2) => $q2->whereIn('establishment_id', explode(',', Parameter::get('establishment', 'EstablecimientosDispositivos')))))
                /*
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedUserAllowance)
                */
                ->paginate(30);
        }

        if($this->index == 'all'){
            //PLANES DE COMPRAS: ALL INDEX 
            $purchasePlans = $query
                /*
                ->where('user_allowance_id', auth()->id())
                ->orWhere('creator_user_id', auth()->id())
                ->orWhere('organizational_unit_allowance_id', auth()->user()->organizationalUnit->id)
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedUserAllowance)
                */
                ->paginate(30);
        }

        if($this->index == 'pending'){
            //PLANES DE COMPRAS: PENDING INDEX
            /** Soy manager de alguna OU hoy? */
            $ous = auth()->user()->amIAuthorityFromOu->pluck('organizational_unit_id')->toArray();

            $purchasePlans = $query
                ->whereHas('approvals', fn($q) => $q->where('active', 1)->whereNull('status')->whereIn('sent_to_ou_id', $ous))
                ->paginate(30);
        }

        if($this->index == 'report: ppl-items'){
            //PLANES DE COMPRAS: REPORT 
            $purchasePlans = PurchasePlan::with('organizationalUnit.establishment', 'userResponsible', 'userCreator', 'programName', 'purchasePlanItems.unspscProduct')->latest()
                /*
                ->where('user_allowance_id', auth()->id())
                ->orWhere('creator_user_id', auth()->id())
                ->orWhere('organizational_unit_allowance_id', auth()->user()->organizationalUnit->id)
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedUserAllowance)
                */
                ->paginate(150);
        }

        return view('livewire.purchase-plan.search-purchase-plan', compact('purchasePlans'));
    }
}
