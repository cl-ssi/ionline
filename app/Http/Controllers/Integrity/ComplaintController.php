<?php

namespace App\Http\Controllers\Integrity;

use App\Models\Integrity\Complaint;
use App\Models\Integrity\ComplaintValue;
use App\Models\Integrity\ComplaintPrinciple;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\Confirmation;
use Illuminate\Support\Facades\Mail;

class ComplaintController extends Controller
{
    /**
    * Enforce middleware.
    */
    public function __construct()
    {
        //$this->middleware('auth', ['only' => ['create', 'store', 'edit', 'delete']]);
        // Alternativly
        $this->middleware('auth', ['except' => ['create', 'store', 'mail']]);
        $this->middleware('permission:Integrity: manage complaints', ['only'=>['index','show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaints = Complaint::All()->sortByDesc('id');
        return view('integrity.index')->withComplaints($complaints);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $values = ComplaintValue::All();
        $principles = ComplaintPrinciple::All();
        return view('integrity.create')->withValues($values)->withPrinciples($principles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $complaint = new Complaint($request->All());
        //$complaint->user_id = Auth::id();
        if($request->hasFile('file'))
            $complaint->file = $request->file('file')->store('integrity')->disk('gcs');
        $complaint->save();

        //Auth::user()
        Mail::to($complaint->email)->send(new Confirmation($complaint));

        /* Correo al encargado de integridad y ética */
        Mail::to('integridad_etica.ssi@redsalud.gob.cl')->send(new Confirmation($complaint));

        return redirect()->route('integrity.complaints.mail', [$complaint]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Integrity\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        return view('integrity.show')->withComplaint($complaint);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Integrity\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function download(Complaint $complaint)
    {
        /* TODO: #91 Mover a google storage */
        return Storage::disk('gcs')->download($complaint->file);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Integrity\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function mail(Complaint $complaint)
    {
        //Mail::to(Auth::user())->send(new Confirmation($complaint));
        return view('integrity.mails.confirmation')->withComplaint($complaint);
        //return view('integrity/mails/confirmation');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Integrity\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Integrity\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Integrity\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {
        //
    }

}
