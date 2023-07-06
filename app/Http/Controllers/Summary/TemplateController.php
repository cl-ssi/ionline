<?php

namespace App\Http\Controllers\Summary;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Summary\Template;
use App\Models\Summary\EventType;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::all();
        return view('summary.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = EventType::all();
        return view('summary.templates.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $eventType = EventType::findOrFail($request->event_type_id);
        if ($request->hasFile('template_file')) {
            $file = $request->file('template_file');
            $filename = $file->getClientOriginalName();
            Template::create([
                'event_type_id' => $eventType->id,
                'name' => $file->getClientOriginalName(),
                'file' => $file->storeAs('ionline/summary/templates/' .
                $eventType->name, $filename, ['disk' => 'gcs']),
            ]);
            session()->flash('success', 'Se añadio la plantilla correctamente');
            return redirect()->route('summary.templates.index');
        }
    }

    public function download(Template $file)
    {
        return Storage::disk('gcs')->download($file->file);
    }
    
}
