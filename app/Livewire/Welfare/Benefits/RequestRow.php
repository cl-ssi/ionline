<?php

namespace App\Livewire\Welfare\Benefits;

use Livewire\Component;
use App\Models\Welfare\Benefits\Request;
use App\Notifications\Welfare\Benefits\RequestTransfer;
use App\Notifications\Welfare\Benefits\RequestAccept;
use App\Notifications\Welfare\Benefits\RequestReject;
use Illuminate\Support\Facades\Storage;

class RequestRow extends Component
{
    public $request;
    public $showTextarea = 0;
    public $observation = '';
    public $acceptedAmount;
    public $folioNumber;
    public $installmentsNumber;

    public function mount($requestId)
    {
        $this->request = Request::with(['subsidy.benefit', 'applicant', 'files'])->findOrFail($requestId);
        $this->observation = $this->request->status_update_observation;
        $this->acceptedAmount = $this->request->accepted_amount;
        $this->folioNumber = $this->request->folio_number;
        $this->installmentsNumber = $this->request->installments_number;
    }

    public function accept()
    {
        $this->request->update([
            'status' => 'Aceptado',
            'status_update_date' => now(),
            'status_update_responsable_id' => auth()->id(),
        ]);

        if ($this->request->applicant && $this->request->applicant->email_personal) {
            $this->request->applicant->notify(new RequestAccept($this->request));
        }

        session()->flash('message', 'La solicitud ha sido aceptada.');
    }

    public function reject()
    {
        $this->showTextarea = 1;
    }

    public function cancel()
    {
        $this->showTextarea = 0;
        $this->observation = '';
    }

    public function saveObservation()
    {
        $this->validate([
            'observation' => 'required|string|max:255', // Validar que la observación no esté vacía
        ]);

        $this->request->update([
            'status_update_observation' => $this->observation,
            'status_update_date' => now(),
            'status_update_responsable_id' => auth()->id(),
        ]);

        session()->flash('message', 'Se guardó la observación.');
    }

    public function saveCancelObservation()
    {
        $this->validate([
            'observation' => 'required|string|max:255', // Validar la observación para rechazar
        ]);

        $this->request->update([
            'status' => 'Rechazado',
            'status_update_observation' => $this->observation,
            'status_update_date' => now(),
            'status_update_responsable_id' => auth()->id(),
        ]);

        $this->observation = $this->request->status_update_observation; // Actualizar la propiedad con el valor guardado

        session()->flash('message', 'Se registró la observación de cancelación.');
        $this->showTextarea = 0; // Ocultar el textarea después de guardar
    }


    public function saveAcceptedAmount()
    {
        $this->request->update([
            'accepted_amount' => $this->acceptedAmount,
            'accepted_amount_date' => now(),
            'accepted_amount_responsable_id' => auth()->id(),
        ]);

        session()->flash('message', 'Se registró el monto aprobado.');
    }

    public function saveFolio()
    {
        $this->request->update([
            'folio_number' => $this->folioNumber,
        ]);

        session()->flash('message', 'Se registró el folio.');
    }

    public function saveInstallmentsNumber()
    {
        $this->request->update([
            'installments_number' => $this->installmentsNumber,
        ]);

        session()->flash('message', 'Se registró el número de cuotas.');
    }

    public function saveTransfer()
    {
        if (!$this->request->accepted_amount || $this->request->accepted_amount <= 0) {
            session()->flash('message', 'No se puede realizar la transferencia. Registre un monto aprobado primero.');
            return;
        }

        $this->request->update([
            'status' => 'Pagado',
            'payed_date' => now(),
            'payed_responsable_id' => auth()->id(),
            'payed_amount' => $this->request->accepted_amount,
        ]);

        if ($this->request->applicant && $this->request->applicant->email_personal) {
            $this->request->applicant->notify(new RequestTransfer($this->request, $this->request->accepted_amount));
        }

        session()->flash('message', 'Se registró la transferencia exitosamente.');
    }


    public function render()
    {
        return view('livewire.welfare.benefits.request-row');
    }
}
