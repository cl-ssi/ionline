<?php

namespace App\Livewire\ServiceRequest\Responsable;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

use App\Models\ServiceRequests\Attachment;
use App\Models\ServiceRequests\Fulfillment;

class OtherHours extends Component
{
    public $serviceRequest;

    public function deleteSignedCertificate(Fulfillment $fulfillment){
        Storage::delete($fulfillment->signedCertificate->signed_file);
        $fulfillment->signatures_file_id = null;
        $fulfillment->save();
        session()->flash('success', 'Se ha borrado exitosamente el certificado de cumplimiento.');
        $this->serviceRequest->refresh();
    }

    public function deleteAttachment(Attachment $attachment){
        $attachment->delete();
        Storage::delete($attachment->file);
        session()->flash("message", "Su Archivo adjunto ha sido eliminado.");
        $this->serviceRequest->refresh();
    }

    public function render()
    {
        return view('livewire.service-request.responsable.other-hours');
    }
}
