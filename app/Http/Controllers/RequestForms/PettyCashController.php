<?php

namespace App\Http\Controllers\RequestForms;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\PettyCash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PettyCashController extends Controller
{
    public function download(PettyCash $pettyCash)
    {
        $filename = $pettyCash->receipt_type . ' ' .
            $pettyCash->receipt_number . '.' .
            File::extension($pettyCash->file);
        return Storage::disk('gcs')->response($pettyCash->file, $filename);
    }
}
