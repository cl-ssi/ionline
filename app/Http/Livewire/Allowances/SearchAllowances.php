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

    public $index;

    public function render()
    {
        if($this->index == 'sign'){
            $authorities = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', Auth::user()->id);
            if($authorities){
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
                    ->paginate(50)
            ]);
        }

        if($this->index == 'own'){
            return view('livewire.allowances.search-allowances', [
                'allowances' => Allowance::
                    latest()
                    ->where('user_allowance_id', Auth::user()->id)
                    ->orWhere('creator_user_id', Auth::user()->id)
                    ->orWhere('organizational_unit_allowance_id', Auth::user()->organizationalUnit->id)
                    ->paginate(50)
            ]);
        }

        if($this->index == 'all'){
            return view('livewire.allowances.search-allowances', [
                'allowances' => Allowance::
                    latest()
                    ->paginate(50)
            ]);
        }
    }
}
