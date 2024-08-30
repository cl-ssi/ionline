<?php

namespace App\Livewire\ReplacementStaff;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Parameters\Parameter;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Documents\Approval;
use Livewire\WithPagination;
use App\Models\Rrhh\Authority;
use App\Notifications\ReplacementStaff\ApprovalsStatusReport;
use Illuminate\Support\Facades\Notification;

class ApprovalsStatus extends Component
{
    use WithPagination;

    public $selectedSearch;

    public $selectedOuId;
    private $pendings;
    public $pendingsCount = null;
    public $messageNotify = null;
    public $selectedOuIds = array();
    public $selectedOuToNotify;

    public function render()
    {
        $subParams = Parameter::whereIn('parameter', ['SubRRHH', 'SDASSI', 'SubSDGA'])
            ->pluck('value')
            ->toArray();

        $subs = OrganizationalUnit::whereIn('id', $subParams)->get();

        return view('livewire.replacement-staff.approvals-status', [
                'pendings'  => $this->pendings,
                'subs'      => $subs
            ]
        );
    }

    public function showReport(){
        if($this->selectedOuId != null){
            $this->selectedOuIds = OrganizationalUnit::find($this->selectedOuId)->getAllChilds();
        }

        $this->pendings = Approval::where('module', 'Solicitudes de Contración')
            ->where('active', 1)
            ->whereNull('status')
            ->whereIn('sent_to_ou_id', $this->selectedOuIds)
            ->orderBy('created_at', 'ASC')
            ->get();
        
        $this->pendingsCount = $this->pendings->count();
        $this->messageNotify = null;
        // $this->selectedOuId = null;
        // $this->selectedOuIds = null;
    }

    #[On('searchedOu')]
    public function searchedOu(OrganizationalUnit $organizationalUnit)
    {
        $this->selectedOuId = null;
        $this->selectedOuIds[] = $organizationalUnit->id;
        $this->selectedOuToNotify = $organizationalUnit->id;
    }

    public function sendNotificaction(){
        $authority = Authority::getAuthorityFromDate($this->selectedOuToNotify, now(), 'manager');

        if($authority){
            $authority->user->notify(new ApprovalsStatusReport($this->pendingsCount));
            $this->messageNotify = "<b>Estimado Usuario</b>: Se ha envíado la notificación a la unidad organizacional: ".$authority->organizationalUnit->name ;
        }
        else{
            
        }
    }

    public function updatedSelectedSearch(){
        $this->selectedOuId = null;
        $this->selectedOuIds = null;
    }
}
