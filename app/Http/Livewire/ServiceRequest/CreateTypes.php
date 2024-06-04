<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use App\Rrhh\OrganizationalUnit;
use App\Models\User;

class CreateTypes extends Component
{
    public $program_contract_type;
    public $type;
    public $subdirection_ou_id;
    public $responsability_center_ou_id;
    public $subdirections;
    public $responsabilityCenters;
    public $users;
    public $signatures;
    public $signatureFlows = [];
    public $active_contract_count;

    public function change_responsability_center_ou_id(){
        $active_contract_count = OrganizationalUnit::find($this->responsability_center_ou_id)->activeContractCount();
        $this->active_contract_count = $active_contract_count;
        $serviceRequestLimit = OrganizationalUnit::find($this->responsability_center_ou_id)->serviceRequestLimit;
        
        // if($serviceRequestLimit){
        //     $serviceRequestLimit = OrganizationalUnit::find($this->responsability_center_ou_id)->serviceRequestLimit ? OrganizationalUnit::find($this->responsability_center_ou_id)->serviceRequestLimit->max_value : 0;
        //     if($active_contract_count >= $serviceRequestLimit){
        //         session()->flash('message', 'Se alcanzó el máximo de solicitudes de contrato para esta unidad, contacte a RRHH.');
        //         $this->responsability_center_ou_id = null;
        //     }
        // }
    }

    public function render()
    {
        //sst
        if (auth()->user()->organizationalUnit->establishment_id == 38) {
            // if (Authority::getAuthorityFromDate(1, now(), ['manager']) == null) {
            //     dd("falta ingresar autoridad de " . OrganizationalUnit::find(1)->name);
            // }
            // if (Authority::getAuthorityFromDate(2, now(), ['manager']) == null) {
            //     dd("falta ingresar autoridad de " . OrganizationalUnit::find(2)->name);
            // }
            if (Authority::getAuthorityFromDate(40, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(40)->name);
            }
            if (Authority::getAuthorityFromDate(44, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(44)->name);
            }
            if (Authority::getAuthorityFromDate(59, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(59)->name);
            }
        }
        //hetg
        else {
            if (Authority::getAuthorityFromDate(111, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(111)->name);
            }
            if (Authority::getAuthorityFromDate(87, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(87)->name);
            }
            if (Authority::getAuthorityFromDate(86, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(86)->name);
            }
            if (Authority::getAuthorityFromDate(424, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(424)->name);
            }
            if (Authority::getAuthorityFromDate(85, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(85)->name);
            }
            if (Authority::getAuthorityFromDate(84, now(), ['manager']) == null) {
                dd("falta ingresar autoridad de " . OrganizationalUnit::find(84)->name);
            }
        }


        $this->signatureFlows = [];
        if (auth()->user()->organizationalUnit->establishment_id == 1){
            $this->signatureFlows[Authority::getAuthorityFromDate(424, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(424, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(424, now(), ['manager'])->user->id;
            $this->signatureFlows[Authority::getAuthorityFromDate(86, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(86, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(86, now(), ['manager'])->user->id;
            $this->signatureFlows[Authority::getAuthorityFromDate(111, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(111, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(111, now(), ['manager'])->user->id;
            if ($this->subdirection_ou_id == 85){
                $this->signatureFlows[Authority::getAuthorityFromDate(85, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(85, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(85, now(), ['manager'])->user->id;
            }
            $this->signatureFlows[Authority::getAuthorityFromDate(87, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(87, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(87, now(), ['manager'])->user->id;
            $this->signatureFlows[Authority::getAuthorityFromDate(84, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(84, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(84, now(), ['manager'])->user->id;
        }else{
            $this->signatureFlows[Authority::getAuthorityFromDate(59, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(59, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(59, now(), ['manager'])->user->id; // 59 - Planificación y Control de Gestión de Recursos Humanos
            $this->signatureFlows[Authority::getAuthorityFromDate(44, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(44, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(44, now(), ['manager'])->user->id; // 44 - Subdirección de Gestión y Desarrollo de las Personas
            $this->signatureFlows[Authority::getAuthorityFromDate(40, now(), ['manager'])->position . " - " . Authority::getAuthorityFromDate(40, now(), ['manager'])->organizationalUnit->name] = Authority::getAuthorityFromDate(40, now(), ['manager'])->user->id; // 31 - Subdirección de Recursos Físicos y Financieros
        }


        $this->signatures = [];
        foreach($this->signatureFlows as $ou_name => $user_id)
        {
        $this->signatures[$ou_name] = User::find($user_id);
        }

        return view('livewire.service-request.create-types');
    }
}
