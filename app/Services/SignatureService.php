<?php

namespace App\Services;

use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\StoreUser;
use App\User;
use Illuminate\Support\Facades\Storage;

class SignatureService
{
    public $control;
    public $visator = null;
    public $signer = null;

    public function __construct(Control $control)
    {
        $this->control = $control;

        $this->getVisator();
        $this->getSigner();
        $this->sendSignatureRequest();
    }

    public function sendSignatureRequest()
    {
        $type = '';
        $control = $this->control;
        $store = $control->store;
        $pdf = \PDF::loadView('warehouse.pdf.report-reception', compact('store', 'control', 'type'));
        $pdf = $pdf->download('filename.pdf');

        $signature = Signature::create([
            'user_id' => $this->visator->id,
            'responsable_id' => $this->visator->id,
            'ou_id' => $this->visator->organizational_unit_id,
            'request_date' => now(),
            'document_type' => 'Acta',
            'subject' => 'Acta de recepción #' . $control->id,
            'description' => " Acta de recepción #" . $control->id,
            'endorse_type' => 'Visación en cadena de responsabilidad',
            'visatorAsSignature' => true,
        ]);

        $signature->update([
            'distribution' => $this->visator->email,
        ]);

        $signaturesFile = new SignaturesFile();
        $signaturesFile->md5_file = md5($pdf);
        $signaturesFile->file_type = 'documento';
        $signaturesFile->signature_id = $signature->id;
        $signaturesFile->save();

        $filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
        $signaturesFile->update(['file' => $filePath]);
        Storage::disk('public')->put($filePath, $pdf);

        // Visator
        $signaturesFlow = new SignaturesFlow();
        $signaturesFlow->signatures_file_id = $signaturesFile->id;
        $signaturesFlow->type = 'visador';
        $signaturesFlow->user_id = $this->visator->id;
        $signaturesFlow->ou_id = $this->visator->organizational_unit_id;
        $signaturesFlow->save();


        $signature->update([
            'distribution' => $signature->distribution . ',' . $this->signer->email,
        ]);

        // Signer
        $signaturesFlow = new SignaturesFlow();
        $signaturesFlow->signatures_file_id = $signaturesFile->id;
        $signaturesFlow->type = 'firmante';
        $signaturesFlow->user_id = $this->signer->id;
        $signaturesFlow->ou_id = $this->signer->organizational_unit_id;
        $signaturesFlow->save();
    }

    public function getVisator()
    {
        $this->visator = $this->control->store->visator;
    }

    public function getSigner()
    {
        $this->signer = $this->control->signer;
    }
}