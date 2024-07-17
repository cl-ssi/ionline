<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

use App\Models\Parameters\Parameter;
use App\Rrhh\OrganizationalUnit;
use App\Models\Documents\Approval;
use Livewire\WithPagination;
use App\Rrhh\Authority;
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
        
        $this->pendingsCount = $this->pendings->count();
        $this->messageNotify = null;
    }

    public function searchedOu(OrganizationalUnit $organizationalUnit)
    {
        $this->selectedOuId = $organizationalUnit->id;
    }

    public function sendNotificaction(){
        $authority = Authority::getAuthorityFromDate($this->selectedOuId, now(), 'manager');

        if($authority){
            $authority->user->notify(new ApprovalsStatusReport($this->pendingsCount));
            $this->messageNotify = "<b>Estimado Usuario</b>: Se ha envíado la notificación a la unidad organizacional: ".$authority->organizationalUnit->name ;
        }
        else{
            dd('no hay autoridad');
        }
        
    }
}
