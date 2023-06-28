<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use App\Models\Summary\SummaryEventFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Summary\Event;
use Illuminate\Http\Request;

class SummaryFileController extends Controller
{
    //

    public function downloadFile(SummaryEventFile $file)
    {
        return Storage::disk('gcs')->download($file->file);
    }

    public function deleteFile(SummaryEventFile $file)
    {
        $file->delete();
        Storage::disk('gcs')->delete($file->file);
        session()->flash('danger', 'Su Archivo ha sido eliminado Exitosamente.');
        return redirect()->route('summary.index');
    }

    public function update(Request $request, Event $event)
    {

        /** Sacar el código de carga y eliminación de archivo a otros metodos de archivos */
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $summaryEventFile = new SummaryEventFile();
                $filename = $file->getClientOriginalName();
                $summaryEventFile->summary_event_id = $event->id;
                $summaryEventFile->summary_id = $event->summary->id;
                $summaryEventFile->name = $file->getClientOriginalName();

                $summaryEventFile->file = $file->storeAs('ionline/summary/' .
                    $event->summary->id, $filename, ['disk' => 'gcs']);

                $summaryEventFile->save();
            }
        }
    }
}
