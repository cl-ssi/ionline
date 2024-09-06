<?php

namespace App\Http\Controllers\Integrity;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Parameters\Parameter;
use App\Models\Integrity\ComplaintValue;
use App\Models\Integrity\ComplaintPrinciple;
use App\Models\Integrity\Complaint;
use App\Mail\Confirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



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
        $complaints = Complaint::latest()->paginate(25);
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
        $rules = [
            'user_id' => ['required', 'exists:users,id'],
        ];
        
        $messages = [
            'user_id.exists' => 'El run :input digitado no es un funcionario válido, recordar que es sin puntos y sin digito verificador.',
        ];
        
        $validator = Validator::make($request->all(), $rules,$messages);
        $validator->validate();
        $complaint = new Complaint($request->All());
        //$complaint->user_id = Auth::id();
        if($request->hasFile('file'))
            $complaint->file = $request->file('file')->store('ionline/integrity', ['disk' => 'gcs']);
        $complaint->save();

        /* Enviar email al usuario sólo si es un mail bien formateado válido */
        if (filter_var($complaint->email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($complaint->email)->send(new Confirmation($complaint));
        }

        /* Correo al encargado de integridad y ética */
        $emailParameter = Parameter::get('integrity','email');
        if($emailParameter) {
            Mail::to($emailParameter)->send(new Confirmation($complaint));
        }

        return view('integrity.mails.confirmation')->withComplaint($complaint);

        // return redirect()->route('integrity.complaints.mail', [$complaint]);
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
        return Storage::download($complaint->file);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Integrity\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function mail(Complaint $complaint)
    {
        //Mail::to(auth()->user())->send(new Confirmation($complaint));
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
