<?php

namespace App\Http\Controllers\Documents;

use App\Documents\ParteFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ParteFileController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documents\ParteEvent  $parteEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParteFile $file)
    {
        Storage::disk('gcs')->delete($file->file);
        $file->delete();
        session()->flash('success', 'El archivo ha sido eliminado');
        return back();
    }
}
