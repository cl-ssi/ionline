<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Documents\Approval;

class ApprovalController extends Controller
{
    /**
     * Display the specified pdf.
     *
     * @param  \App\Models\Documents\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function showPdf(Approval $approval)
    {
        /* TODO: Pasar al file controller */
        return Storage::response($approval->document_pdf_path);
    }

    /**
     * Retorna archivo firmado
     *
     * @param  Approval  $approval
     * @return void
     */
    public function signedApproval(Approval $approval)
    {
        header('Content-Type: application/pdf');
        echo base64_decode($approval->filename_base64);
    }
}
