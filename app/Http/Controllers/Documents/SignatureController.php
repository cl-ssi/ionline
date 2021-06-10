<?php

namespace App\Http\Controllers\Documents;

use App\Agreements\Addendum;
use App\Agreements\Agreement;
use App\Documents\Document;
use App\Http\Controllers\Controller;
use App\Mail\NewSignatureRequest;
use App\Mail\SignedDocument;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\SignatureFlow;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Documents\Signature;
use App\User;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Rrhh\Authority;
use Throwable;
use App\Documents\Parte;
use App\Documents\ParteFile;
use Carbon\Carbon;

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
        //dd(Auth::user()->id);
        $users[0] = Auth::user()->id;

        $ous_secretary = Authority::getAmIAuthorityFromOu(date('Y-m-d'), 'secretary', Auth::user()->id);
        foreach ($ous_secretary as $secretary) {
            $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')->user_id;
        }

        if ($tab == 'mis_documentos') {
            $mySignatures = Signature::whereIn('responsable_id', $users)
                ->orderByDesc('id')
                ->get();
        }

        if ($tab == 'pendientes') {
            $pendingSignaturesFlows = SignaturesFlow::whereIn('user_id', $users)
                ->where('status', null)
                ->get();

            $signedSignaturesFlows = SignaturesFlow::whereIn('user_id', $users)
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
    public function create($xAxis = null, $yAxis = null)
    {
        return view('documents.signatures.create', compact('xAxis', 'yAxis'));
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

            if ($request->file_base_64) {
                $documentFile = base64_decode($request->file_base_64);
                $signaturesFile->md5_file = $request->md5_file;
//                $signaturesFile->file = $request->file_base_64;
            } else {
                $documentFile = file_get_contents($request->file('document')->getRealPath());
                $signaturesFile->md5_file = md5_file($request->file('document'));
//                $signaturesFile->file = base64_encode(file_get_contents($documentFile->getRealPath()));
            }

            $signaturesFile->file_type = 'documento';
            $signaturesFile->save();
            $signaturesFileDocumentId = $signaturesFile->id;

            $filePath = 'ionline/signatures/original/' . $signaturesFileDocumentId . '.pdf';
            $signaturesFile->update(['file' => $filePath,]);
            Storage::disk('gcs')->put($filePath, $documentFile);

            if ($request->annexed) {
                foreach ($request->annexed as $key => $annexed) {
                    $signaturesFile = new SignaturesFile();
                    $signaturesFile->signature_id = $signature->id;
                    $documentFile = $annexed;

//                    $signaturesFile->file = base64_encode($annexed->openFile()->fread($documentFile->getSize()));
                    $signaturesFile->file_type = 'anexo';
                    $signaturesFile->save();

                    $documentFile = $annexed->openFile()->fread($documentFile->getSize());
                    $filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
                    $signaturesFile->update(['file' => $filePath,]);
                    Storage::disk('gcs')->put($filePath, $documentFile);
                }
            }

            if ($request->ou_id_signer != null) {
                $signaturesFlow = new SignaturesFlow();
                $signaturesFlow->signatures_file_id = $signaturesFileDocumentId;
                $signaturesFlow->type = 'firmante';
                $signaturesFlow->ou_id = $request->ou_id_signer;
                $signaturesFlow->user_id = $request->user_signer;
                $signaturesFlow->custom_x_axis = $request->custom_x_axis;
                $signaturesFlow->custom_y_axis = $request->custom_y_axis;
                $signaturesFlow->save();
            }

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

            if ($request->has('document_id')) {
                $document = Document::find($request->document_id);
                $document->update(['file_to_sign_id' => $signaturesFileDocumentId,
                ]);
            }

            if ($request->has('agreement_id')) {
                $agreement = Agreement::find($request->agreement_id);
                $request->signature_type == 'visators' ? $agreement->update(['file_to_endorse_id' => $signaturesFileDocumentId, 'file_to_sign_id' => null]) : $agreement->update(['file_to_sign_id' => $signaturesFileDocumentId]);
            }

            if ($request->has('addendum_id')) {
                $addendum = Addendum::find($request->addendum_id);
                $request->signature_type == 'visators' ? $addendum->update(['file_to_endorse_id' => $signaturesFileDocumentId, 'file_to_sign_id' => null]) : $addendum->update(['file_to_sign_id' => $signaturesFileDocumentId]);
            }

            //Envía los correos correspondientes
            if ($request->endorse_type != 'Visación en cadena de responsabilidad') {
                foreach ($signature->signaturesFlows as $signaturesFlow) {
                    Mail::to($signaturesFlow->userSigner->email)
                        ->send(new NewSignatureRequest($signaturesFlow));
                }
            }elseif($signature->signaturesFlowVisator->where('sign_position',1)->count() === 1){
                $firstVisatorFlow = $signature->signaturesFlowVisator->where('sign_position', 1)->first();
                Mail::to($firstVisatorFlow->userSigner->email)
                    ->send(new NewSignatureRequest($firstVisatorFlow));
            } elseif ($signature->signaturesFlowSigner) {
                Mail::to($signature->signaturesFlowSigner->userSigner->email)
                    ->send(new NewSignatureRequest($signature->signaturesFlowSigner));
            }


            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }


        //se crea documento si va de Destinatarios del documento al director
        $destinatarios = $request->recipients;

        $dest_vec = array_map('trim', explode(',', $destinatarios));

        foreach($dest_vec as $dest){
            if($dest== 'director.ssi@redsalud.gob.cl' or $dest=='director.ssi@redsalud.gov.cl' or $dest=='direccion.ssi@redsalud.gov.cl')
            {
                $tipo = null;
                switch($request->document_type)
                    {
                        case 'Memorando':
                            $this->tipo ='Memo';
                        break;
                        case 'Resoluciones':
                            $this->tipo ='Resolución';
                        break;
                        default:
                        $this->tipo = $request->document_type;
                        break;
                    }


                $parte = Parte::create([                    
                    'entered_at' => Carbon::today(),           
                    'type' => $this->tipo,
                    'date' => $request->request_date,
                    'subject' => $request->subject,
                    'origin' => 'Parte generado desde Solicitud de Firma N°'.$signature->id,
                    
                ]);                

                ParteFile::create([
                    'parte_id' => $parte->id,
                    'file' => $filePath,
                    'name' => $signaturesFileDocumentId.'.pdf',
                    
                ]);

            }
            

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
     * @throws Exception
     */
    public function update(Request $request, Signature $signature): RedirectResponse
    {
        $signature->fill($request->all());
        $signature->save();

//        if ($signature->hasSignedOrRejectedFlow) {
//            $signature->signaturesFlows->toQuery()->update(['status' => null]);
//        }

        if ($request->hasFile('document')) {
            $signatureFileDocumento = $signature->signaturesFiles->where('file_type', 'documento')->first();
//            $signatureFileDocumento->file = base64_encode(file_get_contents($request->file('document')->getRealPath()));

            Storage::disk('gcs')->delete($signatureFileDocumento->file);
            $documentFile = file_get_contents($request->file('document')->getRealPath());
            $filePath = 'ionline/signatures/original/' . $signatureFileDocumento->id . '.pdf';
//            $signatureFileDocumento->update(['file' => $filePath,]);

            Storage::disk('gcs')->put($filePath, $documentFile);

            $signatureFileDocumento->save();
        }

        if ($request->annexed) {
            if ($signature->signaturesFiles->where('file_type', 'anexo')->count() > 0) {
                foreach ($signature->signaturesFiles->where('file_type', 'anexo') as $anexo) {
                    Storage::disk('gcs')->delete($anexo->file);
                    $anexo->delete();
                }
            }

            foreach ($request->annexed as $key => $annexed) {
                $signaturesFile = new SignaturesFile();
                $signaturesFile->signature_id = $signature->id;
                $documentFile = $annexed;

//                $signaturesFile->file = base64_encode($annexed->openFile()->fread($documentFile->getSize()));
                $signaturesFile->file_type = 'anexo';
                $signaturesFile->save();

                $documentFile = $annexed->openFile()->fread($documentFile->getSize());
                $filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
                $signaturesFile->update(['file' => $filePath,]);
                Storage::disk('gcs')->put($filePath, $documentFile);
            }
        }

        //borrar y crea nuevos flows
        $signatureFileDocumento = $signature->signaturesFiles->where('file_type', 'documento')->first();
        $signatureFileDocumento->signaturesFlows()->delete();

        if ($request->ou_id_signer != null) {
            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->signatures_file_id = $signatureFileDocumento->id;
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->ou_id = $request->ou_id_signer;
            $signaturesFlow->user_id = $request->user_signer;
            $signaturesFlow->save();
        }

        if ($request->has('ou_id_visator')) {
            foreach ($request->ou_id_visator as $key => $ou_id_visator) {
                $signaturesFlow = new SignaturesFlow();
                $signaturesFlow->signatures_file_id = $signatureFileDocumento->id;
                $signaturesFlow->type = 'visador';
                $signaturesFlow->ou_id = $ou_id_visator;
                $signaturesFlow->user_id = $request->user_visator[$key];
                $signaturesFlow->sign_position = $key + 1;
//                    $signaturesFlow->status = false;
                $signaturesFlow->save();
            }
        }

        $signatureFileDocumento->update(['signed_file' => null,
        ]);

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

            if ($signaturesFile->document) {
                $signaturesFile->document->update(['file_to_sign_id' => null,
                ]);
            }

            if ($signaturesFile->suitabilityResult) {
                $signaturesFile->suitabilityResult->update(['signed_certificate_id' => null,
                ]);
            }

            foreach ($signaturesFile->signaturesFlows as $signaturesFlow) {
                $signaturesFlow->delete();
            }

            if ($signaturesFile->file) {
                Storage::disk('gcs')->delete($signaturesFile->file);
            }

            if ($signaturesFile->signed_file) {
                Storage::disk('gcs')->delete($signaturesFile->signed_file);
            }

            $signaturesFile->delete();
        }
        $signature->delete();

        session()->flash('info', "La solicitud de firma $signature->id ha sido eliminada.");
        return redirect()->route('documents.signatures.index', ['mis_documentos']);
    }

    public function showPdf(SignaturesFile $signaturesFile)
    {
        if ($signaturesFile->file_type == 'documento') {
            if ($signaturesFile->signed_file) {
                return Storage::disk('gcs')->response($signaturesFile->signed_file);
            } else {
                return Storage::disk('gcs')->response($signaturesFile->file);
            }
        } else {
            return Storage::disk('gcs')->response($signaturesFile->file);
        }


//        header('Content-Type: application/pdf');
//        if ($signaturesFile->file_type == 'documento') {
//            if ($signaturesFile->signed_file) {
//                echo base64_decode($signaturesFile->signed_file);
//            } else {
//                echo base64_decode($signaturesFile->file);
//            }
//        } else {
//            echo base64_decode($signaturesFile->file);
//        }
    }

    public function showPdfFromFile(Request $request)
    {
        header('Content-Type: application/pdf');
        echo base64_decode($request->file_base_64);
    }

    public function showPdfAnexo(SignaturesFile $anexo)
    {
        return Storage::disk('gcs')->response($anexo->file);
    }


    public function verify(Request $request)
    {
        if ($request->id && $request->verification_code) {
            $signaturesFile = SignaturesFile::find($request->id);
            if ($signaturesFile->verification_code == $request->verification_code) {
                return Storage::disk('gcs')->response($signaturesFile->signed_file);
//                header('Content-Type: application/pdf');
//                echo base64_decode($signaturesFile->signed_file);
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
        session()->flash('success', $message);
        return redirect()->route('rrhh.service-request.fulfillment.edit', $fulfillment->serviceRequest->id);
    }

    public function rejectSignature(Request $request, $idSignatureFlow)
    {
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

    public function signModal($pendingSignaturesFlowId)
    {
        $pendingSignaturesFlow = SignaturesFlow::find($pendingSignaturesFlowId);
        return view('documents.signatures.partials.sign_modal_content', compact('pendingSignaturesFlow'));
    }

}
