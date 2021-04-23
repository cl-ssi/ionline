<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\ServiceRequests\Fulfillment;
use Exception;
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
        $pendingSignaturesFlows = null;
        $signedSignaturesFlows = null;

        if ($tab == 'mis_documentos') {
            $mySignatures = Signature::where('responsable_id', Auth::id())
                ->orderByDesc('id')
                ->get();
        }

        if ($tab == 'pendientes') {
            $pendingSignaturesFlows = SignaturesFlow::where('user_id', Auth::id())
                ->where('status', null)
                ->get();

            $signedSignaturesFlows = SignaturesFlow::where('user_id', Auth::id())
                ->whereNotNull('status')
                ->orderByDesc('id')
                ->get();
        }

        return view('documents.signatures.index', compact('mySignatures', 'pendingSignaturesFlows', 'signedSignaturesFlows', 'tab'));
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
            $signaturesFile->file_type = 'documento';
            $signaturesFile->md5_file = md5_file($documentFile);
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
//            $signaturesFlow->status = false;
            $signaturesFlow->save();

            if ($request->has('ou_id_visator')) {
                foreach ($request->ou_id_visator as $key => $ou_id_visator) {
                    $signaturesFlow = new SignaturesFlow();
                    $signaturesFlow->signatures_file_id = $signaturesFileDocumentId;
                    $signaturesFlow->type = 'visador';
                    $signaturesFlow->ou_id = $ou_id_visator;
                    $signaturesFlow->user_id = $request->user_visator[$key];
                    $signaturesFlow->sign_position = $key + 1;
//                    $signaturesFlow->status = false;
                    $signaturesFlow->save();
                }
            }

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        session()->flash('info', 'La solicitud de firma ' . $signature->id . ' ha sido creada.');
        return redirect()->route('documents.signatures.index', ['mis_documentos']);
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

        if ($signature->hasSignedOrRejectedFlow) {
            $signature->signaturesFlows->toQuery()->update(['status' => null]);
        }

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
        return redirect()->route('documents.signatures.index', ['mis_documentos']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Signature $signature
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Signature $signature): RedirectResponse
    {
        foreach ($signature->signaturesFiles as $signaturesFile) {
            foreach ($signaturesFile->signaturesFlows as $signaturesFlow) {
                $signaturesFlow->delete();
            }
            $signaturesFile->delete();
        }
        $signature->delete();

        session()->flash('info', "La solicitud de firma $signature->id ha sido eliminada.");
        return redirect()->route('documents.signatures.index', ['mis_documentos']);
    }

    public function showPdf(SignaturesFile $signaturesFile)
    {
        header('Content-Type: application/pdf');
        if ($signaturesFile->file_type == 'documento') {
            if ($signaturesFile->signed_file) {
                echo base64_decode($signaturesFile->signed_file);
            } else {
                echo base64_decode($signaturesFile->file);
            }
        } else {
            echo base64_decode($signaturesFile->file);
        }


    }

    public function showPdfAnexo(SignaturesFile $anexo)
    {
        header('Content-Type: application/pdf');
        echo base64_decode($anexo->file);
    }


    public function verify(Request $request)
    {
        if ($request->id && $request->verification_code) {
            //TODO verificar que exista algun signaturesFile
            $signaturesFile = SignaturesFile::find($request->id);
            if ($signaturesFile->verification_code == $request->verification_code) {
                header('Content-Type: application/pdf');
                echo base64_decode($signaturesFile->signed_file);
            } else {
                session()->flash('warning', 'El código de verificación no corresponde con el documento.');
                return view('documents.signatures.verify');
            }

        } else {
            return view('documents.signatures.verify');
        }
    }

    public function callbackFirma($message, $modelId, SignaturesFile $signaturesFile = null)
    {
        $fulfillment = Fulfillment::find($modelId);

        if (!$signaturesFile) {
            session()->flash('danger', $message);
            return redirect()->route('rrhh.service-request.fulfillment.edit', $fulfillment->serviceRequest->id);
        }

        $fulfillment->signatures_file_id = $signaturesFile->id;
        $fulfillment->save();
        // header('Content-Type: application/pdf');
        // echo base64_decode($signaturesFile->signed_file);
        session()->flash('success', $message);
        return redirect()->route('rrhh.service-request.fulfillment.edit', $fulfillment->serviceRequest->id);
    }

    public function rejectSignature(Request $request, $idSignatureFlow)
    {
        //TODO verificar orden de firmas
        //TODO Al rechazar un flow en responsabilidad en cadena deberian rechazarse todos los siguientes flows

        $idSigFlow = SignaturesFlow::find($idSignatureFlow);
        $idSigFlow->update(['status' => 0, 'observation' => $request->observacion]);
        session()->flash('success', "La solicitud ha sido rechazada");
        return redirect()->route('documents.signatures.index', ['pendientes']);
    }

    public function signatureFlows($signatureID)
    {
        $signatureFlowsModal = Signature::find($signatureID)->signaturesFlows;
        return view('documents.signatures.partials.flows_modal_body', compact('signatureFlowsModal'));
    }
}
