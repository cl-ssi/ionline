<?php

namespace App\Http\Controllers\Rem;

use App\Http\Controllers\Controller;
use App\Models\Rem\RemFile;
use App\Models\Rem\UserRem;
use Illuminate\Support\Facades\Storage;


class RemFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $now = now()->startOfMonth();

        for ($i = 1; $i <= 12; $i++) {
            $this->rango[] = $now->clone();
            $now->subMonth('1');
        }

        $dates = $this->rango;

        if (auth()->user()->can('Rem: admin')) {
            $rem_establishments = UserRem::all();
        } else {
            $rem_establishments = auth()->user()->remEstablishments;
        }
        return view('rem.file.index', compact('dates', 'rem_establishments'));
    }

    public function download(RemFile $rem_file)
    {
        return Storage::disk('gcs')->download($rem_file->filename);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RemFile  $rem_file
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemFile $rem_file)
    {
        //
        $rem_file->delete();
        Storage::disk('gcs')->delete($rem_file->filename);
        session()->flash('success', 'el Archivo fue eliminado exitosamente');
        return redirect()->route('rem.files.index');
    }
}
