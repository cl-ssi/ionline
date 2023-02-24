<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\Documents\Document;
use App\Http\Controllers\Controller;
use App\Models\RequestForms\FundToBeSettled;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FundToBeSettledController extends Controller
{
    public function download(FundToBeSettled $fundToBeSettled)
    {
        $document = Document::find($fundToBeSettled->document_id);
        return Storage::disk('gcs')->response($document->fileToSign->signed_file);
    }
}
