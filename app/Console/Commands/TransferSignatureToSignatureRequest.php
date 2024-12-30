<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Documents\Signature;
use App\Models\Documents\SignatureRequest;

class TransferSignatureToSignatureRequest extends Command
{
    protected $signature = 'transfer:signature-to-signature-request';
    protected $description = 'Transfer data from Signature model to SignatureRequest model';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // $signatures = Signature::where('user_id',14104369)->take(5)->get();
        $signatures = Signature::orderBy('id', 'desc')->take(5)->get();

        foreach ($signatures as $signature) {
            
            $status = 'pending';
            $flows = $signature->signaturesFlows;

            if ($signature->endorse_type == "Visación en cadena de responsabilidad") {
                foreach ($flows as $flow) {
                    if ($flow->status == 'rejected') {
                        $status = 'rejected';
                        break;
                    }
                    if ($flow->status == 'approved') {
                        $status = 'approved';
                    }
                }
            } else {
                foreach ($flows as $flow) {
                    if ($flow->status == 'rejected') {
                        $status = 'rejected';
                        break;
                    }
                    if ($flow->status == 'approved') {
                        $status = 'approved';
                    }
                }
            }


            $signatureRequest = new SignatureRequest();
            $signatureRequest->request_date = $signature->request_date;
            $signatureRequest->original_file_path = $signature->signaturesFiles->where('file_type','documento')->first()->id;
            $signatureRequest->original_file_name = $signature->signaturesFiles->where('file_type','documento')->first()->file;
            $signatureRequest->url = $signature->url;
            $signatureRequest->status = $status;
            $signatureRequest->user_id = $signature->responsable_id;
            $signatureRequest->organizational_unit_id = $signature->ou_id;
            $signatureRequest->establishment_id = $signature->organizationalUnit->establishment_id ?? null;
            $signatureRequest->type_id = $signature->type_id;
            $signatureRequest->subject = $signature->subject;
            $signatureRequest->description = $signature->description;
            $signatureRequest->recipients = $signature->recipients;
            $signatureRequest->distribution = $signature->distribution;
            $signatureRequest->reserved = $signature->reserved;
            $signatureRequest->oficial = $signature->visatorAsSignature;
            $signatureRequest->sensitive = false; // Assuming default value
            $signatureRequest->signature_page_lastpage = false; // Assuming default value
            $signatureRequest->signature_page_number = 0; // Assuming default value
            $signatureRequest->response_within_days = 0; // Assuming default value
            $signatureRequest->endorse_type = $signature->endorse_type;
            $signatureRequest->verification_code = null; // Assuming default value
            $signatureRequest->last_approval_id = null; // Assuming default value

            $signatureRequest->save();
        }

        $this->info('Data transfer from Signature to SignatureRequest completed successfully.');
    }
}