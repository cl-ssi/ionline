<?php

namespace App\Http\Controllers\Documents\Partes;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Documents\Numeration;
use App\Http\Controllers\Controller;

class NumerationController extends Controller
{
    /**
    * Show Document
    */
    public function showOriginal(Numeration $numeration)
    {
        return Storage::response($numeration->file_path);
    }

    /**
    * Show Document
    */
    public function showNumerated(Numeration $numeration)
    {
        return Storage::response($numeration->storageFilePath);
    }
}
