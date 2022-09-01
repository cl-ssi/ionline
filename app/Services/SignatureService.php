<?php

namespace App\Services;

use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\User;
use Illuminate\Support\Facades\Storage;

class SignatureService
{
    public $responsible;
    public $documentType;
    public $subject;
    public $description;
    public $endorseType;
    public $visatorAsSignature;
    public $view;
    public $dataView;
    public $signatures;
    public $visators;

    public function addResponsible(User $responsible)
    {
        $this->responsible = $responsible;
    }

    public function addSignature($documentType, $subject, $description, $endorseType, $visatorAsSignature)
    {
        $this->documentType = $documentType;
        $this->subject = $subject;
        $this->description = $description;
        $this->endorseType = $endorseType;
        $this->visatorAsSignature = $visatorAsSignature;
    }

    public function addView($view, $dataView)
    {
        $this->view = $view;
        $this->dataView = $dataView;
    }

    public function addVisators($visators)
    {
        $this->visators = $visators;
    }

    public function addSignatures($signatures)
    {
        $this->signatures = $signatures;
    }

    public function sendRequest()
    {
        // TODO: View or document
        $pdf = \PDF::loadView($this->view, $this->dataView);
        $pdf = $pdf->download('filename.pdf');

        // Signature
        $signature = Signature::create([
            'user_id' => $this->responsible->id,
            'responsable_id' => $this->responsible->id,
            'ou_id' => $this->responsible->organizational_unit_id,
            'request_date' => now(),
            'document_type' => $this->documentType,
            'subject' => $this->subject,
            'description' => $this->description,
            'endorse_type' => $this->endorseType,
            'visatorAsSignature' => $this->visatorAsSignature,
        ]);

        // Signature File
        $signaturesFile = new SignaturesFile();
        $signaturesFile->md5_file = md5($pdf);
        $signaturesFile->file_type = 'documento';
        $signaturesFile->signature_id = $signature->id;
        $signaturesFile->save();

        $filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
        $signaturesFile->update(['file' => $filePath]);
        Storage::disk('public')->put($filePath, $pdf);

        // Visators
        foreach($this->visators as $index => $visator)
        {
            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->signatures_file_id = $signaturesFile->id;
            $signaturesFlow->type = 'visador';
            $signaturesFlow->user_id = $visator->id;
            $signaturesFlow->ou_id = $visator->organizational_unit_id;
            $signaturesFlow->save();

            $signature->update([
                'distribution' => ($index == 0) ? $visator->email : $signature->distribution . ',' . $visator->email,
            ]);
        }

        // Signers
        foreach($this->signatures as $index => $signer)
        {
            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->signatures_file_id = $signaturesFile->id;
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->user_id = $signer->id;
            $signaturesFlow->ou_id = $signer->organizational_unit_id;
            $signaturesFlow->save();

            $signature->update([
                'distribution' => ($index == 0) ? $signer->email : $signature->distribution . ',' . $signer->email,
            ]);
        }

        return $signature;
    }
}