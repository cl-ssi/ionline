<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

use App\Models\Parameters\Parameter;
use App\Rrhh\OrganizationalUnit;
use App\Models\Documents\Approval;
use Livewire\WithPagination;

class ApprovalsStatus extends Component
{
    use WithPagination;

    public $selectedSearch;

    public $selectedOuId;
    private $pendings;

    protected $listeners = ['searchedOu'];

    public function render()
    {
        $subParams = Parameter::
            select('value')
            ->whereIn('parameter', ['SubRRHH', 'SDASSI', 'SubSDGA'])
            ->get()
            ->toArray();

        $subs = OrganizationalUnit::whereIn('id', $subParams)->get();

        return view('livewire.replacement-staff.approvals-status', [
                'pendings'  => $this->pendings,
                'subs'      => $subs
            ]
        );
    }

    public function showReport(){
        $this->pendings = Approval::where('module', 'Solicitudes de Contración')
            ->where('active', 1)
            ->whereNull('status')
            ->where('sent_to_ou_id', $this->selectedOuId)
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function searchedOu(OrganizationalUnit $organizationalUnit)
    {
        $this->selectedOuId = $organizationalUnit->id;
    }
}
