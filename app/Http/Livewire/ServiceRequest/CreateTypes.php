<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use App\User;

class CreateTypes extends Component
{
    public $program_contract_type;
    public $type;

    public $subdirections;
    public $responsabilityCenters;
    public $users;
    public $a;

    public $signatureFlows = [];

    public function mount(){
      $this->users = User::orderBy('name','ASC')->get();
    }

    public function render()
    {
        $this->signatureFlows = [];
        if ($this->type == NULL || $this->type == "Covid") {
          if ($this->program_contract_type == "Mensual") {
            $this->a = "mensual";
            if (Auth::user()->organizationalUnit->establishment_id == 38) {
              //Hector Reyno (CGU)
              if (Auth::user()->organizationalUnit->id == 24) {
                $this->signatureFlows['RRHH CGU'] = 10739552; //RR.HH del CGU
                $this->signatureFlows['Directora CGU'] = 14745638; // 24 - Consultorio General Urbano Dr. Hector Reyno
                $this->signatureFlows['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
                $this->signatureFlows['Planificación CG RRHH'] = 18263660; // 59 - Planificación y Control de Gestión de Recursos Humanos
                $this->signatureFlows['S.G.D.P SSI'] = 14112543; // 44 - Subdirección de Gestión y Desarrollo de las Personas
                $this->signatureFlows['S.D.A SSI'] = 9994426; // 31 - Subdirección de Recursos Físicos y Financieros
                $this->signatureFlows[Authority::getAuthorityFromDate(1,now(),['manager'])->position . " - " . Authority::getAuthorityFromDate(1,now(),['manager'])->user->organizationalUnit->establishment->name] = Authority::getAuthorityFromDate(1,now(),['manager'])->user->id; // 1 - Dirección
              }
              //servicio de salud iqq
              else{
                $this->signatureFlows['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
                $this->signatureFlows['Planificación CG RRHH'] = 18263660; // 59 - Planificación y Control de Gestión de Recursos Humanos
                $this->signatureFlows['S.G.D.P SSI'] = 14112543; // 44 - Subdirección de Gestión y Desarrollo de las Personas
                $this->signatureFlows['S.D.A SSI'] = 9994426; // 31 - Subdirección de Recursos Físicos y Financieros
                $this->signatureFlows[Authority::getAuthorityFromDate(1,now(),['manager'])->position . " - " . Authority::getAuthorityFromDate(1,now(),['manager'])->user->organizationalUnit->establishment->name] = Authority::getAuthorityFromDate(1,now(),['manager'])->user->id; // 1 - Dirección
              }
            }
            //hospital
            elseif(Auth::user()->organizationalUnit->establishment_id == 1){
              $this->signatureFlows['Subdirector'] = 12621281; // 88 - Subdirección Médica - 9882506 - (iriondo)
              $this->signatureFlows['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
              $this->signatureFlows['S.G.D.P Hospital'] = 16593799; // 86 - Subdirección de Gestión de Desarrollo de las Personas
              $this->signatureFlows['Jefe Finanzas'] = 13866194; // 11 - Departamento de Finanzas
              $this->signatureFlows['S.G.D.P SSI'] = 14112543; // 44 - Subdirección de Gestión y Desarrollo de las Personas
              $this->signatureFlows[Authority::getAuthorityFromDate(84,now(),['manager'])->position . " - " . Authority::getAuthorityFromDate(84,now(),['manager'])->user->organizationalUnit->establishment->name] = Authority::getAuthorityFromDate(84,now(),['manager'])->user->id; // 84 - Dirección
            }
          }elseif ($this->program_contract_type == "Horas") {
            $this->a = "horas";
            if (Auth::user()->organizationalUnit->establishment_id == 38) {
              //Hector Reyno (CGU)
              if (Auth::user()->organizationalUnit->id == 24) {
                $this->signatureFlows['Funcionario'] = 10739552; // 24 - Consultorio General Urbano Dr. Hector Reyno
                $this->signatureFlows['Directora CGU'] = 14745638; // 24 - Consultorio General Urbano Dr. Hector Reyno
                $this->signatureFlows['S.G.D.P SSI'] = 14112543; // 44 - Subdirección de Gestión y Desarrollo de las Personas
                $this->signatureFlows['S.D.A SSI'] = 9994426; // 31 - Subdirección de Recursos Físicos y Financieros
              }
              //servicio de salud iqq
              else{
                $this->signatureFlows['Planificación CG RRHH'] = 18263660; // 59 - Planificación y Control de Gestión de Recursos Humanos
                $this->signatureFlows['S.G.D.P SSI'] = 14112543; // 44 - Subdirección de Gestión y Desarrollo de las Personas
                $this->signatureFlows['S.D.A SSI'] = 9994426; // 31 - Subdirección de Recursos Físicos y Financieros
              }
            }
            //hospital
            elseif(Auth::user()->organizationalUnit->establishment_id == 1){
              $this->signatureFlows['Subdirector'] = 12621281; // 88 - Subdirección Médica - 9882506 - (iriondo)
              $this->signatureFlows['S.G.D.P Hospital'] = 16593799; // 86 - Subdirección de Gestión de Desarrollo de las Personas
              $this->signatureFlows['Jefe Finanzas'] = 13866194; // 11 - Departamento de Finanzas
            }
          }
        }else{
          if (Auth::user()->organizationalUnit->establishment_id == 1) {
            $this->a = "suma";
            $this->signatureFlows['S.G.D.P Hospital'] = 16593799;
            $this->signatureFlows['Jefe Finanzas'] = 13866194;
            $this->signatureFlows[Authority::getAuthorityFromDate(84,now(),['manager'])->position . " - " . Authority::getAuthorityFromDate(84,now(),['manager'])->user->organizationalUnit->establishment->name] = Authority::getAuthorityFromDate(84,now(),['manager'])->user->id;
          }else{
            $this->signatureFlows['Planificación CG RRHH'] = 18263660; // 59 - Planificación y Control de Gestión de Recursos Humanos
            $this->signatureFlows['S.G.D.P SSI'] = 14112543; // 44 - Subdirección de Gestión y Desarrollo de las Personas
            $this->signatureFlows['S.D.A SSI'] = 9994426; // 31 - Subdirección de Recursos Físicos y Financieros
          }
        }

        // $this->emit('listener',$this->program_contract_type, $this->type);
        return view('livewire.service-request.create-types');
    }
}
