<?php

namespace App\Livewire\Allowances;

use App\Models\User;
use Livewire\Component;
use App\Models\Allowances\Allowance;
use Livewire\WithPagination;
use App\Models\Rrhh\Authority;
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
    public $selectedEstablishment = null;

    public $index;

    protected $queryString = ['selectedStatus', 
        'selectedId', 
        'selectedUserAllowance', 
        'selectedStatusSirh', 
        'selectedEstablishment'];

    public function render()
    {   
        if($this->index == 'sign'){
            if(auth()->user()->hasPermissionTo('Allowances: sirh')){
                return view('livewire.allowances.search-allowances', [
                    'allowances' => Allowance::with([
                            'userCreator',
                            'userAllowance',
                            'allowanceSigns',
                            'organizationalUnitAllowance',
                            'originCommune',
                            'destinations.commune',
                            'destinations.locality',
                            'approvals',
                            'allowanceEstablishment'
                        ])
                        ->orderBy('correlative', 'DESC')
                        ->whereDoesntHave("archive", function($subQuery){
                            $subQuery->where('user_id', auth()->id());
                        })
                        ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                        ->search($this->selectedStatus,
                            $this->selectedId,
                            $this->selectedUserAllowance,
                            $this->selectedStatusSirh,
                            $this->selectedEstablishment)
                        ->paginate(50)
                ]);
            }
        }

        if($this->index == 'contabilidad'){
            if(auth()->user()->hasPermissionTo('Allowances: contabilidad')){
                return view('livewire.allowances.search-allowances', [
                    'allowances' => Allowance::with([
                            'userCreator',
                            'userAllowance',
                            'allowanceSigns',
                            'organizationalUnitAllowance',
                            'originCommune',
                            'destinations.commune',
                            'destinations.locality',
                            'approvals',
                            'allowanceEstablishment'
                        ])
                        ->orderBy('correlative', 'DESC')
                        ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                        ->whereHas("allowanceSigns", function($subQuery){
                            $subQuery->where('event_type', 'contabilidad')
                                ->whereIn('status', ['pending', 'accepted', 'rejected']);
                        })
                        ->doesntHave('archive')
                        ->search($this->selectedStatus,
                            $this->selectedId,
                            $this->selectedUserAllowance,
                            $this->selectedStatusSirh,
                            $this->selectedEstablishment)
                        ->paginate(50)
                ]);
            }
        }


        if($this->index == 'archived'){
            if(auth()->user()->hasPermissionTo('Allowances: sirh')){
                return view('livewire.allowances.search-allowances', [
                    'allowances' => Allowance::with([
                            'userCreator',
                            'userAllowance',
                            'allowanceSigns',
                            'organizationalUnitAllowance',
                            'originCommune',
                            'destinations.commune',
                            'destinations.locality',
                            'approvals',
                            'allowanceEstablishment'
                        ])
                        ->orderBy('correlative', 'DESC')
                        ->whereHas("archive", function($subQuery){
                            $subQuery->where('user_id', auth()->id());
                        })
                        ->search($this->selectedStatus,
                            $this->selectedId,
                            $this->selectedUserAllowance,
                            $this->selectedStatusSirh,
                            $this->selectedEstablishment)
                        ->paginate(50)
                ]);
            }
        }

        if($this->index == 'own'){
            //CREADOS, MIOS Y DE MI U.O.
            return view('livewire.allowances.search-allowances', [
                    'allowances' => Allowance::with([
                        'userCreator',
                        'userAllowance',
                        'allowanceSigns',
                        'organizationalUnitAllowance',
                        'originCommune',
                        'destinations.commune',
                        'destinations.locality',
                        'approvals',
                        'allowanceEstablishment'
                    ])
                    ->orderBy('correlative', 'DESC')
                    ->where('user_allowance_id', auth()->id())
                    ->orWhere('creator_user_id', auth()->id())
                    ->orWhere('organizational_unit_allowance_id', auth()->user()->organizationalUnit->id)
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance,
                        $this->selectedStatusSirh,
                        $this->selectedEstablishment)
                    ->paginate(50)
            ]);
        }

        if($this->index == 'all'){
            if(auth()->user()->hasPermissionTo('Allowances: all establishment')){
                return view('livewire.allowances.search-allowances', [
                        'allowances' => Allowance::with([
                            'userCreator',
                            'userAllowance',
                            'allowanceSigns',
                            'organizationalUnitAllowance',
                            'originCommune',
                            'destinations.commune',
                            'destinations.locality',
                            'approvals',
                            'allowanceEstablishment'
                        ])
                        ->orderBy('correlative', 'DESC')
                        ->search($this->selectedStatus,
                            $this->selectedId,
                            $this->selectedUserAllowance,
                            $this->selectedStatusSirh,
                            $this->selectedEstablishment)
                        ->paginate(50)
                ]);
            }
            if(auth()->user()->hasPermissionTo('Allowances: all')){
                return view('livewire.allowances.search-allowances', [
                    'allowances' => Allowance::with([
                        'userCreator',
                        'userAllowance',
                        'allowanceSigns',
                        'organizationalUnitAllowance',
                        'originCommune',
                        'destinations.commune',
                        'destinations.locality',
                        'approvals',
                        'allowanceEstablishment'
                    ])
                    ->orderBy('correlative', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->where('establishment_id', Auth::user()->organizationalUnit->establishment_id)
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance,
                        $this->selectedStatusSirh,
                        $this->selectedEstablishment)
                    ->paginate(50)
                ]);
            }
        }

        //INDEX CON VIÁTICOS PARA FIRMA DE DIRECCIÓN
        if($this->index == 'director'){
            return view('livewire.allowances.search-allowances', [
                'allowances' => Allowance::
                    with([
                        'userCreator',
                        'userAllowance',
                        'allowanceSigns',
                        'organizationalUnitAllowance',
                        'originCommune',
                        'destinations.commune',
                        'destinations.locality',
                        'approvals',
                        'allowanceEstablishment'
                    ])
                    ->orderBy('correlative', 'DESC')
                    ->whereHas("Approvals", function($subQuery){
                        $subQuery->where('sent_to_ou_id', Parameter::get('ou','DireccionSSI'));
                    })
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance,
                        $this->selectedStatusSirh,
                        $this->selectedEstablishment)
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
