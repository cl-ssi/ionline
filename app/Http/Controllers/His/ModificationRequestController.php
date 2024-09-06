<?php

namespace App\Http\Controllers\His;

use Illuminate\Http\Request;
use App\Models\His\ModificationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\His\ModificationRequestFile;

class ModificationRequestController extends Controller
{
    public function show($modification_request_id)
    {
        $modificationRequest = ModificationRequest::find($modification_request_id);
        $establishment = auth()->user()->organizationalUnit->establishment;
        $documentFile = \PDF::loadView('his.modification-request-show', compact('modificationRequest','establishment'));
        return $documentFile->stream();
    }

    public function download(ModificationRequestFile $file)
    {
        if(Storage::exists($file->file)){
            return Storage::response($file->file, mb_convert_encoding($file->name,'ASCII'));
        }else{
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado.');
        }
    }
}
