<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class InfoRrhh extends Component
{
    public $serviceRequest;

    public $resolutionNumber;
    public $resolutionDate;
    public $netAmount;
    public $grossAmount;
    public $sirhContractRegistration;

    public function mount()
    {
        $this->resolutionNumber = $this->serviceRequest->resolution_number;
        $this->resolutionDate = $this->serviceRequest->resolution_date ? $this->serviceRequest->resolution_date->format('Y-m-d') : null;
        $this->netAmount = $this->serviceRequest->net_amount;
        $this->grossAmount = $this->serviceRequest->gross_amount;
        $this->sirhContractRegistration = $this->serviceRequest->sirh_contract_registration;
    }

    public function saveInfoRrhh()
    {
        // Validar y guardar los datos
        // $this->validate([
        //     'resolutionNumber' => 'required',
        //     'resolutionDate' => 'required|date',
        //     'netAmount' => 'required',
        //     'grossAmount' => 'required',
        //     'sirhContractRegistration' => 'required',
        // ]);

        // Actualizar los campos en el modelo de ServiceRequest
        $this->serviceRequest->resolution_number = $this->resolutionNumber;
        $this->serviceRequest->resolution_date = $this->resolutionDate;
        $this->serviceRequest->net_amount = $this->netAmount;
        $this->serviceRequest->gross_amount = $this->grossAmount;
        $this->serviceRequest->sirh_contract_registration = $this->sirhContractRegistration;

        // Guardar el modelo
        $this->serviceRequest->save();

        // Mostrar mensaje de éxito
        Session::flash('message', 'La información ha sido guardada correctamente.');

        // Redireccionar o realizar otras acciones si es necesario

        // Volver a cargar el componente
        $this->mount();
    }



    public function render()
    {

        return view('livewire.service-request.info-rrhh');
    }
}
