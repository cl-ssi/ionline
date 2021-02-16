<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Documents\Signature;
use App\User;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $tab
     * @return Application|Factory|View|Response
     */
    public function index(string $tab)
    {
        $mySignatures = null;
        $pendingSignatures = null;
        $signedSignatures = null;

        if ($tab == 'mis_documentos') {
            $mySignatures = Signature::where('responsable_id', Auth::id())->get();
        }

        if ($tab == 'pendientes') {
            $pendingSignatures = Signature::wherehas('signaturesFiles', function ($q) {
                $q->whereHas('signaturesFlows', function ($q) {
                    $q->where('user_id', Auth::id())
                        ->where('status', 0);
                });
            })->get();

            $signedSignatures = Signature::wherehas('signaturesFiles', function ($q) {
                $q->whereHas('signaturesFlows', function ($q) {
                    $q->where('user_id', Auth::id())
                        ->where('status', 1);
                });
            })->get();
        }

        return view('documents.signatures.index', compact('mySignatures', 'pendingSignatures', 'signedSignatures', 'tab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $users = User::orderBy('name', 'ASC')->get();
        $organizationalUnits = OrganizationalUnit::orderBy('id', 'asc')->get();
        return view('documents.signatures.create', compact('users', 'organizationalUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $signature = new Signature($request->All());
            $signature->user_id = Auth::id();
            $signature->ou_id = Auth::user()->organizationalUnit->id;
            $signature->responsable_id = Auth::id();
            $signature->save();

            $signaturesFile = new SignaturesFile();
            $signaturesFile->signature_id = $signature->id;
            $documentFile = $request->file('document');
            $signaturesFile->file = base64_encode(file_get_contents($documentFile->getRealPath()));
//        $signaturesFile->file = base64_encode($documentFile->openFile()->fread($documentFile->getSize()));
            $signaturesFile->file_type = 'documento';
            $signaturesFile->md5_file = md5_file($request->file('document'));
            $signaturesFile->save();
            $signaturesFileDocumentId = $signaturesFile->id;

            if ($request->annexed) {
                foreach ($request->annexed as $key => $annexed) {
                    $signaturesFile = new SignaturesFile();
                    $signaturesFile->signature_id = $signature->id;
                    $documentFile = $annexed;

                    $signaturesFile->file = base64_encode($annexed->openFile()->fread($documentFile->getSize()));
                    $signaturesFile->file_type = 'anexo';
                    $signaturesFile->save();
                }
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

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        session()->flash('info', 'La solicitud de firma ' . $signature->id . ' ha sido creada.');
        return redirect()->route('documents.signatures.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Signature $signature
     * @return Response
     */
    public function show(Signature $signature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Signature $signature
     * @return Application|Factory|View|Response
     */
    public function edit(Signature $signature)
    {
        return view('documents.signatures.edit', compact('signature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Signature $signature
     * @return RedirectResponse
     */
    public function update(Request $request, Signature $signature): RedirectResponse
    {
        $signature->fill($request->all());
        $signature->save();

        if ($request->hasFile('document')) {
            $signatureFileDocumento = $signature->signaturesFiles->where('file_type', 'documento')->first();
            $signatureFileDocumento->file = base64_encode(file_get_contents($request->file('document')->getRealPath()));
            $signatureFileDocumento->save();
        }

        if ($request->annexed) {
            if ($signature->signaturesFiles->where('file_type', 'anexo')->count() > 0) {
                foreach ($signature->signaturesFiles->where('file_type', 'anexo') as $anexo) {
                    $anexo->delete();
                }
            }

            foreach ($request->annexed as $key => $annexed) {
                $signaturesFile = new SignaturesFile();
                $signaturesFile->signature_id = $signature->id;
                $documentFile = $annexed;

                $signaturesFile->file = base64_encode($annexed->openFile()->fread($documentFile->getSize()));
                $signaturesFile->file_type = 'anexo';
                $signaturesFile->save();
            }
        }

        session()->flash('info', "Los datos de la firma $signature->id han sido actualizados.");

        return redirect()->route('documents.signatures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Signature $signature
     * @return Response
     */
    public function destroy(Signature $signature): Response
    {
        //
    }

    public function showPdfDocumento(Signature $signature)
    {
        header('Content-Type: application/pdf');
        if ($signature->signaturesFiles->where('file_type', 'documento')->first()->signed_file) {
            echo base64_decode($signature->signaturesFiles->where('file_type', 'documento')->first()->signed_file);
        } else {
            echo base64_decode($signature->signaturesFiles->where('file_type', 'documento')->first()->file);
        }

    }

    public function showPdfAnexo(SignaturesFile $anexo)
    {
        header('Content-Type: application/pdf');
        echo base64_decode($anexo->file);
    }
}
