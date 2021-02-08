<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use Illuminate\Http\Request;
use App\Models\Documents\Signature;
use App\User;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Support\Facades\Auth;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signatures = Signature::all();
        return view('documents.signatures.index', compact('signatures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('name','ASC')->get();
        $organizationalUnits = OrganizationalUnit::orderBy('id','asc')->get();
        return view('documents.signatures.create', compact('users','organizationalUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        $signature = new Signature($request->All());
        $signature->user_id = Auth::id();
        $signature->ou_id = Auth::user()->organizationalUnit->id;
        $signature->responsable_id = Auth::id();
        $signature->save();

        $signaturesFile = new SignaturesFile();
        $signaturesFile->signature_id = $signature->id;
        $documentFile = $request->file('document');
        $signaturesFile->file = base64_encode($documentFile->openFile()->fread($documentFile->getSize()));
        $signaturesFile->file_type = 'documento';
        $signaturesFile->save();
        $signaturesFileDocumentId = $signaturesFile->id;

        foreach ($request->annexed as $key => $annexed) {
            $signaturesFile = new SignaturesFile();
            $signaturesFile->signature_id = $signature->id;
            $documentFile = $annexed;
            $signaturesFile->file = base64_encode($annexed->openFile()->fread($documentFile->getSize()));
            $signaturesFile->file_type = 'anexo';
            $signaturesFile->save();
        }

        $signaturesFlow = new SignaturesFlow();
        $signaturesFlow->signatures_file_id = $signaturesFileDocumentId;
        $signaturesFlow->type = 'firmante';
        $signaturesFlow->ou_id = $request->ou_id_signer;
        $signaturesFlow->user_id = $request->user_signer;
        $signaturesFlow->status = false;
        $signaturesFlow->save();

        if ($request->has('ou_id_visator')) {
            foreach ($request->ou_id_visator as $key => $ou_id_visator) {
                $signaturesFlow = new SignaturesFlow();
                $signaturesFlow->signatures_file_id = $signaturesFileDocumentId;
                $signaturesFlow->type = 'visador';
                $signaturesFlow->ou_id = $ou_id_visator;
                $signaturesFlow->user_id = $request->user_visator[$key];
                $signaturesFlow->sign_position = $key + 1;
                $signaturesFlow->status = false;
                $signaturesFlow->save();
            }
        }

//        header('Content-Type: application/pdf');
//        echo base64_decode($signaturesFile->file);

        session()->flash('info', 'La solicitud de firma '.$signature->id.' ha sido creada.');
        return redirect()->route('documents.signatures.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documents\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function show(Signature $signature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documents\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function edit(Signature $signature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documents\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signature $signature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documents\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signature $signature)
    {
        //
    }
}
