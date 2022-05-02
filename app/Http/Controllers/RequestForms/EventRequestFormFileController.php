<?php

namespace App\Http\Controllers\RequestForms;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\EventRequestFormFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventRequestFormFileController extends Controller
{
    public function showFile(EventRequestFormFile $eventRequestFormFile)
    {
        return Storage::disk('gcs')->response($eventRequestFormFile->file, $eventRequestFormFile->name);
    }
}
