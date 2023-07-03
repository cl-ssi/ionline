<?php

namespace App\Http\Livewire\Welfare\AmiPass;

use Livewire\Component;
use App\Models\Establishment;
use App\Models\Welfare\AmiPass\BeneficiaryRequest;

class NewBeneficiaryRequest extends Component
{

    public $jefatura = '';
    public $correoElectronico = '';
    public $cargoUnidad = '';
    public $selectedOption = '';
    public $establecimientos;
    public $selectedEstablishmentId = '';


    //Campos del BeneficiaryRequest       
    public $motivoRequerimiento = '';
    public $nombreFuncionarioReemplazar = '';
    public $nombreCompleto = '';
    public $rutFuncionario = '';
    public $dondeCumpliraFunciones = '';
    public $correoPersonal = '';
    public $celular = '';
    public $fechaInicioContrato = '';
    public $fechaTerminoContrato = '';
    public $jornadaLaboral = '';
    public $residencia = '';
    public $haUtilizadoAmipass = '';
    public $fechaNacimiento = '';
    public $establecimiento = '';
    public $estado = '';
    public $amiManagerId = '';
    public $amiManagerAt = '';


    public function render()
    {

        if ($this->selectedOption === 'yo') {
            $this->jefatura = auth()->user()->full_name;
            $this->correoElectronico = auth()->user()->email;
            $this->cargoUnidad = auth()->user()->organizationalUnit->name;
            $this->selectedEstablishmentId = auth()->user()->organizationalUnit->establishment_id; // Actualiza el valor según los datos disponibles del usuario logeado
        } else {
            $this->resetFields();
        }
        return view('livewire.welfare.ami-pass.new-beneficiary-request');
    }

    public function mount()
    {
        $establishments_ids = explode(',', env('APP_SS_ESTABLISHMENTS'));
        $this->establecimientos = Establishment::whereIn('id', $establishments_ids)->orderBy('official_name')->get();
    }

    public function resetFields()
    {
        $this->jefatura = '';
        $this->correoElectronico = '';
        $this->cargoUnidad = '';
        $this->selectedEstablishmentId = '';
    }


    public function save()
    {
        // Aquí puedes realizar la lógica necesaria para guardar los datos en el store

        // Por ejemplo, puedes utilizar el método `create` del modelo correspondiente:
        BeneficiaryRequest::create([
            'nombre_jefatura' => $this->jefatura,
            'cargo_unidad_departamento' => $this->cargoUnidad,
            'correo_jefatura' => $this->correoElectronico,
            'establecimiento' => $this->selectedEstablishmentId,
            'motivo_requerimiento' => $this->motivoRequerimiento,
            'nombre_funcionario_reemplazar' => $this->nombreFuncionarioReemplazar,
            'nombre_completo' => $this->nombreCompleto,
            'rut_funcionario' => $this->rutFuncionario,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'correo_personal' => $this->correoPersonal,
            'celular' => $this->celular,
            'fecha_inicio_contrato' => $this->fechaInicioContrato,
            'fecha_termino_contrato' => $this->fechaTerminoContrato,
            'donde_cumplira_funciones' => $this->dondeCumpliraFunciones,
            'jornada_laboral' => $this->jornadaLaboral,
            'residencia' => $this->residencia,
            'ha_utilizado_amipass' => $this->haUtilizadoAmipass,
            
        ]);

        
    }
}
