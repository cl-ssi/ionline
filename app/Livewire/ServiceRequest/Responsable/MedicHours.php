<?php

namespace App\Livewire\ServiceRequest\Responsable;

use Livewire\Component;

use App\Models\ServiceRequests\Attachment;
use App\Models\ServiceRequests\Fulfillment;
use Illuminate\Support\Facades\Storage;

class MedicHours extends Component
{
    public $fulfillment;

    public function deleteAttachment(Attachment $attachment){
        $attachment->delete();
        Storage::delete($attachment->file);
        session()->flash("message", "Su Archivo adjunto ha sido eliminado.");
        $this->fulfillment->refresh();
    }

    public function deleteResponsableVb(Fulfillment $fulfillment){
        $fulfillment->responsable_approbation = null;
        $fulfillment->responsable_approbation_date = null;
        $fulfillment->responsable_approver_id = null;

        $fulfillment->rrhh_approbation = null;
        $fulfillment->rrhh_approbation_date = null;
        $fulfillment->rrhh_approver_id = null;

        $fulfillment->finances_approbation = null;
        $fulfillment->finances_approbation_date = null;
        $fulfillment->finances_approver_id = null;

        $fulfillment->signatures_file_id = null;

        $fulfillment->save();
        $this->fulfillment->refresh();

        session()->flash("message", "Se ha borrado exitosamente el visto bueno de responsable.");
    }

    public function deleteSignedCertificatePdf(Fulfillment $fulfillment){
        Storage::delete($fulfillment->signedCertificate->signed_file);
        $fulfillment->signatures_file_id = null;
        $fulfillment->save();
        session()->flash("message", "Se ha borrado exitosamente el certificado de cumplimiento.");
        $this->fulfillment->refresh();
    }

    public function render()
    {
        return view('livewire.service-request.responsable.medic-hours');
    }
}
