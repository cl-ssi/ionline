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
        if( Storage::disk('gcs')->exists($file->storage_path) ) {
            return Storage::response($file->storage_path);
        } 
        else {
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado.');
        }
    }
}
