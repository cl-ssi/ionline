<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Summary\Summary;
use App\Models\Summary\SummaryEvent;
use App\Models\Summary\EventType;
use App\Models\Summary\SummaryEventFile;
use Illuminate\Support\Facades\Storage;




class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $summaries = Summary::all();
        return view('summary.index', compact('summaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('summary.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $summary = new Summary($request->All());
        $summary->creator_id = auth()->user()->id;
        $summary->status = "En Proceso";
        $summary->start_at = now();
        $summary->establishment_id = auth()->user()->organizationalUnit->establishment->id;

        $event = EventType::first(); // Obtiene el primer registro de la tabla Event
        if ($event) {
            $summary->save();
            $summaryevent = new SummaryEvent();
            $summaryevent->event_id = $event->id;
            $summaryevent->start_date = now();
            $summaryevent->summary_id = $summary->id;
            $summaryevent->creator_id = auth()->user()->id;
            $summaryevent->save();
            session()->flash('success', 'Se creo el sumario correctamente.');
        } else {
            session()->flash('warning', 'No existe creado el primer evento del sumario');
        }

        return redirect()->route('summary.index');
    }

    public function nextEventStore(Request $request)
    {
        $summaryevent = new SummaryEvent($request->all());
        /* TODO: UTILIZAR el helper, now(), today() no es neceario importar carbón para esto */
        $summaryevent->start_date = now();
        $summaryevent->creator_id = auth()->user()->id;
        $summaryevent->save();
        session()->flash('success', 'Se creo el Proximo evento exitosamente');
        return redirect()->route('summary.index');
    }


    public function closeSummary(Request $request, $summaryId)
    {

        $closeDate = $request->input('closeDate');
        $observation = $request->input('observation');

        $summary = Summary::find($summaryId);
        $summary->end_date = $closeDate;
        $summary->observation = $observation;


        $summary->save();

        // Redireccionar o mostrar mensaje de éxito
        return redirect()->back()->with('success', 'Sumario cerrado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Summary $summary)
    {
        return view('summary.edit', compact('summary'));
    }

    public function body(SummaryEvent $summaryEvent)
    {
        //

        return view('summary.body.edit', compact('summaryEvent'));
    }

    public function bodyUpdate(Request $request, SummaryEvent $summaryEvent)
    {
        $summaryEvent->fill($request->all());
        $summaryEvent->save();

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $summaryEventFile = new SummaryEventFile();
                $filename = $file->getClientOriginalName();
                $summaryEventFile->summary_event_id = $summaryEvent->id;
                $summaryEventFile->summary_id = $summaryEvent->summary->id;
                $summaryEventFile->name = $file->getClientOriginalName();

                $summaryEventFile->file = $file->storeAs('ionline/summary/' .
                    $summaryEvent->summary->id, $filename, ['disk' => 'gcs']);

                $summaryEventFile->save();
            }
        }

        session()->flash('success', 'Evento ' . $summaryEvent->event->name . ' del sumario ' . $summaryEvent->summary->name . ' Actualizado exitosamente');
        return redirect()->route('summary.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
