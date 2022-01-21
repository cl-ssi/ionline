<?php

namespace App\Http\Controllers\RequestForms;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\AttachedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachedFilesController extends Controller
{
    public function download(AttachedFile $attachedFile)
    {
        // $filename = $attachedFile->document_type . ' ' .
        //     $attachedFile->tender_id . '.' .
        //     File::extension($attachedFile->file);
        return Storage::disk('gcs')->response($attachedFile->file);
    }
}
