<?php

namespace App\Http\Controllers\RNIdb;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class RNIdbController extends Controller
{
    public function index()
    {
        $files = Storage::disk('gcs')->listContents('ionline/rni_db');
        return view('rni_db.index', compact('files'));
    }

    public function update(Request $request)
    {
        if($request->hasFile('file')){
            // Delete Files first, just only updated file storing
            Storage::disk('gcs')->delete(Storage::disk('gcs')->allFiles('ionline/rni_db'));
            $originalname = $request->file('file')->getClientOriginalName();
            $request->file->storeAs('ionline/rni_db', $originalname, ['disk' => 'gcs']);
        }
        return redirect()->route('indicators.rni_db.index')->with('success', 'Base de datos RNI se actualiza satisfactoriamente.');
    }

    public function download($file)
    {
        $filename = 'ionline/rni_db/'.$file;
        return Storage::disk('gcs')->download($filename, mb_convert_encoding($file,'ASCII'));
    }

}
