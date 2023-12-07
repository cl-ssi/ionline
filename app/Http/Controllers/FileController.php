<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
    * Download
    */
    public function download(File $file)
    {
        return Storage::response($file->storage_path);
    }
}
