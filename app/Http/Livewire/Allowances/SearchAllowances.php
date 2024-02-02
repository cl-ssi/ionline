<?php

namespace App\Http\Livewire\Allowances;

use Livewire\Component;
use App\Models\Allowances\Allowance;
use Livewire\WithPagination;
use App\Rrhh\Authority;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Parameters\Parameter;
use App\Traits\ArchiveTrait;

class SearchAllowances extends Component
{
    use ArchiveTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    

    public $selectedStatus = null;
    public $selectedId = null;
    public $selectedUserAllowance = null;
    public $selectedStatusSirh = null;

    public $index;

    protected $queryString = ['selectedStatus', 'selectedId'];

    public function render()
    {   
        if($this->index == 'sign'){
            if(auth()->user()->hasPermissionTo('Allowances: sirh')){
                return view('livewire.allowances.search-allowances', [
                    'allowances' => Allowance::with([
                            'userCreator',
                            'userAllowance',
                            'organizationalUnitCreator',
                            'organizationalUnitAllowance',
                            'allowanceSigns',
                            'allowanceSigns.organizationalUnit',
                            'originCommune',
                            'destinationCommune.locality',
                            'allowanceSignature'
                        ])
                        ->latest()
                        ->doesntHave('archive')
                        ->search($this->selectedStatus,
                            $this->selectedId,
                            $this->selectedUserAllowance,
                            $this->selectedStatusSirh)
                        ->paginate(50)
                ]);
            }
        }

        if($this->index == 'archived'){
            if(auth()->user()->hasPermissionTo('Allowances: sirh')){
                return view('livewire.allowances.search-allowances', [
                    'allowances' => Allowance::
                        latest()
                        ->has('archive')
                        ->search($this->selectedStatus,
                            $this->selectedId,
                            $this->selectedUserAllowance,
                            $this->selectedStatusSirh)
                        ->paginate(50)
                ]);
            }
        }

        if($this->index == 'own'){
            //CREADOS, MIOS Y DE MI U.O.
            return view('livewire.allowances.search-allowances', [
                'allowances' => Allowance::
                    latest()
                    ->where('user_allowance_id', Auth::user()->id)
                    ->orWhere('creator_user_id', Auth::user()->id)
                    ->orWhere('organizational_unit_allowance_id', Auth::user()->organizationalUnit->id)
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance,
                        $this->selectedStatusSirh)
                    ->paginate(50)
            ]);
        }

        if($this->index == 'all'){
            return view('livewire.allowances.search-allowances', [
                'allowances' => Allowance::with([
                        'userCreator',
                        'userAllowance',
                        'organizationalUnitCreator',
                        'organizationalUnitAllowance',
                        'allowanceSigns',
                        'allowanceSigns.organizationalUnit',
                        'originCommune',
                        'destinationCommune',
                        'allowanceSignature'
                    ])
                    ->orderBy('id', 'DESC')
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance,
                        $this->selectedStatusSirh)
                    ->paginate(50)
            ]);
        }

        //INDEX CON VIÁTICOS PARA FIRMA DE DIRECCIÓN
        if($this->index == 'director'){
            return view('livewire.allowances.search-allowances', [
                'allowances' => Allowance::
                    latest()
                    ->whereHas("Approvals", function($subQuery){
                        $subQuery->where('sent_to_ou_id', Parameter::get('ou','DireccionSSI'));
                    })
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance,
                        $this->selectedStatusSirh)
                    ->paginate(50)
            ]);
        }
    }

    public function searchedUserAllowance(User $user){
        // dd($user);
        $this->userAllowanceId = $user->id;
    }

    //RESET PAGE
    public function updatingSelectedStatus(){
        $this->resetPage();
    }
    public function updatingSelectedId(){
        $this->resetPage();
    }
    public function updatingSelectedUserAllowance(){
        $this->resetPage();
    }
}
