<?php

namespace App\Http\Controllers\Documents\Agreements;

use App\Http\Controllers\Controller;
use App\Models\Documents\Agreements\Certificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class CertificateController extends Controller
{
    public function view(int $record): Response
    {
        $certificate = Certificate::findOrFail($record);
    
        return Pdf::loadView('documents.agreements.certificates.view', [
            'record' => $certificate
        ])->stream();
    }
}
