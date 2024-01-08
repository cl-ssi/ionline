<?php

namespace App\Http\Livewire\Allowances;

use Livewire\Component;
use App\Models\Allowances\Allowance;
use Livewire\WithPagination;
use App\Rrhh\Authority;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SearchAllowances extends Component
{
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
                    'allowances' => Allowance::
                        latest()
                        ->search($this->selectedStatus,
                            $this->selectedId,
                            $this->selectedUserAllowance,
                            $this->selectedStatusSirh)
                        ->paginate(50)
                ]);
            }
            /*
            $authorities = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', Auth::user()->id);
            if($authorities->isNotEmpty()){
                foreach ($authorities as $authority){
                    $iam_authorities_in[] = $authority->organizational_unit_id;
                }
            }
            else{
                $iam_authorities_in = [];
            }

            return view('livewire.allowances.search-allowances', [
                'allowances' => Allowance::
                    latest()
                    ->whereHas('allowanceSigns', function($q) use ($iam_authorities_in){
                        $q->Where('organizational_unit_id', $iam_authorities_in);
                    })
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance)
                    ->paginate(50)
            ]);
            */
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
