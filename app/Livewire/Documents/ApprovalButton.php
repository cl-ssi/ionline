<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use App\Traits\ApprovalTrait;
use App\Models\Documents\Approval;

class ApprovalButton extends Component
{
    use ApprovalTrait;

    public Approval $approval;

    /**
     * Parámetros del livewire:
     *      @livewire('documents.approval-button', [
     *          'approval' => $approval, 
     *          'redirect_route' => null, // (opcional) Redireccionar a una ruta despues de aprobar/rechazar
     *          'redirect_parameter' => null, // (opcional) Corresponde al id de la ruta 
     *          'button_text' => null, // (Opcional) Texto del boton, ej: "Boton de aprobación"
     *          'button_size' => null, // (Opcional) Tamaño del boton, ej: 'btn-sm', 'btn-lg', etc.
     *      ])
     */
    public $redirect_route = null;
    public $redirect_parameter = null;
    public $button_text = null;
    public $button_size = null;


    public $showModal = false;
    public $approver_observation;
    public $approvalSelected;
    public $otp;
    public $message;

    public function render()
    {
        return view('livewire.documents.approval-button');
    }
}
