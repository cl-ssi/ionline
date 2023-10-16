<?php

namespace App\Http\Livewire\Welfare\Amipass;

use Livewire\Component;
use App\Models\Establishment;
use App\Models\Welfare\Amipass\BeneficiaryRequest;

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
    public $estado = '';
    public $amiManagerId = '';
    public $amiManagerAt = '';
    public $establishmentModel = '';


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
        return view('livewire.welfare.amipass.new-beneficiary-request')->extends('layouts.bt4.app');
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
        $this->validate([
            'jefatura' => 'required',
            'correoElectronico' => 'required|email',
            'cargoUnidad' => 'required',
            'selectedEstablishmentId' => 'required',
            'motivoRequerimiento' => 'required',
            'nombreFuncionarioReemplazar' => 'nullable',
            'nombreCompleto' => 'required',
            'rutFuncionario' => 'required',
            'fechaNacimiento' => 'required|date',
            'correoPersonal' => 'required|email',
            'celular' => 'required',
            'fechaInicioContrato' => 'nullable|date',
            'fechaTerminoContrato' => 'nullable|date',
            'dondeCumpliraFunciones' => 'nullable',
            'jornadaLaboral' => 'nullable',
            'residencia' => 'nullable',
            'haUtilizadoAmipass' => 'nullable',
        ]);

        $this->establishmentModel = Establishment::findOrFail($this->selectedEstablishmentId);



        BeneficiaryRequest::create([
            'nombre_jefatura' => $this->jefatura,
            'cargo_unidad_departamento' => $this->cargoUnidad,
            'correo_jefatura' => $this->correoElectronico,
            'establecimiento' => $this->establishmentModel->name,
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

        session()->flash('success', 'Se ha creado exitosamente');
        return redirect()->route('welfare.amipass.requests-manager');
    }
}
