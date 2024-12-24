<?php

namespace App\Observers\Documents;

use App\Models\Documents\SignatureRequest;

class SignatureRequestObserver
{
    /**
     * Handle the SignatureRequest "creating" event.
     */
    public function creating(SignatureRequest $signatureRequest): void
    {
        $signatureRequest->user()->associate(auth()->user());
        $signatureRequest->organizationalUnit()->associate(auth()->user()->organizationalUnit);
        $signatureRequest->establishment()->associate(auth()->user()->establishment);
    }

    /**
     * Handle the SignatureRequest "created" event.
     */
    public function created(SignatureRequest $signatureRequest): void
    {
        // dd($this->record);
        // dd($this->data);
        $endorseType      = $signatureRequest->endorse_type->value;
        $signatures       = $signatureRequest->signatures()->orderBy('created_at')->get();
        $visations        = $signatureRequest->visations()->orderBy('created_at')->get();
        $previousApproval = null;

        switch ($endorseType) {
            case 'without': // No requiere visación
                foreach ($signatures as $index => $signature) {
                    $signature->active               = $index === 0;
                    $signature->previous_approval_id = $previousApproval?->id;
                    $signature->save();
                    $previousApproval = $signature;
                }
                break;
            case 'optional': // Visación opcional
                foreach ($visations as $index => $visation) {
                    $visation->active = true;
                    $visation->save();
                }
                foreach ($signatures as $index => $signature) {
                    $signature->active               = $index === 0;
                    $signature->previous_approval_id = $previousApproval?->id;
                    $signature->save();
                    $previousApproval = $signature;
                }
                break;
            case 'chain': // Visación en cadena de responsabilidad
                foreach ($visations as $index => $visation) {
                    $visation->active               = $index === 0;
                    $visation->previous_approval_id = $previousApproval?->id;
                    $visation->save();
                    $previousApproval = $visation;
                }
                foreach ($signatures as $index => $signature) {
                    $signature->active               = false;
                    $signature->previous_approval_id = $previousApproval?->id;
                    $signature->save();
                    $previousApproval = $signature;
                }
                break;
        }
    }

    /**
     * Handle the SignatureRequest "updated" event.
     */
    public function updated(SignatureRequest $signatureRequest): void
    {
        //
    }

    /**
     * Handle the SignatureRequest "deleted" event.
     */
    public function deleted(SignatureRequest $signatureRequest): void
    {
        $signatureRequest->approvals()->delete();
        $signatureRequest->files()->delete();
    }

    /**
     * Handle the SignatureRequest "restored" event.
     */
    public function restored(SignatureRequest $signatureRequest): void
    {
        //
    }

    /**
     * Handle the SignatureRequest "force deleted" event.
     */
    public function forceDeleted(SignatureRequest $signatureRequest): void
    {
        //
    }
}
