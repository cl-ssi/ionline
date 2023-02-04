<?php

namespace App\Http\Controllers\Documents;

use App\Agreements\Addendum;
use App\Agreements\Agreement;
use App\Models\Documents\Document;
use App\Http\Controllers\Controller;
use App\Mail\NewSignatureRequest;
use App\Mail\SignedDocument;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\SignatureFlow;
use App\Rules\CommaSeparatedEmails;
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
use App\Models\Documents\Parte;
use App\Models\Documents\ParteFile;
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
        $signedSignaturesFlows = null;
        $pendingSignaturesFlows = null;
        $users[0] = Auth::user()->id;

        if(Auth::user()->iAmSubrogantOf->count() > 0){
            foreach(Auth::user()->getIAmSubrogantOfAttribute() as $surrogacy){
                array_push($users, $surrogacy->id);
            }
        }

        $myAuthorities = collect();
        $ous_secretary = Authority::getAmIAuthorityFromOu(date('Y-m-d'), 'secretary', Auth::user()->id);
        foreach ($ous_secretary as $secretary) {
            $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')->user_id;
            $allTimeAuthorities = Authority::getAuthorityFromAllTime($secretary->OrganizationalUnit->id, 'manager');

            foreach($allTimeAuthorities as $allTimeAuthority){
                if(!in_array($allTimeAuthority->user_id, $users)){
                    $myAuthorities->push($allTimeAuthority);
                }
            }
        }

        if ($tab == 'mis_documentos') {
            //Firmas del usuario y del manager actual de ou
            $mySignatures = Signature::whereIn('responsable_id', $users);

            //Firmas de managers anteriores de la ou
            foreach ($myAuthorities as $myAuthority){
                $authoritiesSignatures = Signature::where('responsable_id', $myAuthority->user_id)
                ->whereBetween('created_at', [$myAuthority->from, $myAuthority->to]);

                $mySignatures = $mySignatures->unionAll($authoritiesSignatures);
            }
            $mySignatures = $mySignatures->orderByDesc('id')->paginate(20);
        }

        if ($tab == 'pendientes') {
            //Firmas del usuario y del manager actual de ou
            $pendingSignaturesFlows = SignaturesFlow::whereIn('user_id', $users)
                ->whereNull('status')
                ->whereHas('signaturesFile.signature', function ($q) {
                    $q->whereNull('rejected_at');
                });

            //Firmas de managers anteriores de la ou
            foreach ($myAuthorities as $myAuthority){
                $authoritiesPendingSignaturesFlows = SignaturesFlow::where('user_id', $myAuthority->user_id)
                    ->whereNull('status')
                    ->whereHas('signaturesFile.signature', function ($q) {
                        $q->whereNull('rejected_at');
                    })
                    ->whereBetween('signature_date', [$myAuthority->from, $myAuthority->to]);

                    $pendingSignaturesFlows = $pendingSignaturesFlows->unionAll($authoritiesPendingSignaturesFlows);
            }
            $pendingSignaturesFlows = $pendingSignaturesFlows->get();

            //Firmas del usuario y del manager actual de ou
            $signedSignaturesFlows = SignaturesFlow::whereIn('user_id', $users)
                ->where(function ($q) {
                    $q->whereNotNull('status')
                        ->orWhereHas('signaturesFile.signature', function ($q) {
                            $q->whereNotNull('rejected_at');
                        });
                });

            //Firmas de managers anteriores de la ou
            foreach ($myAuthorities as $myAuthority){
                $authoritiesSignedSignaturesFlows = SignaturesFlow::where('user_id', $myAuthority->user_id)
                ->where(function ($q) {
                    $q->whereNotNull('status')
                        ->orWhereHas('signaturesFile.signature', function ($q) {
                            $q->whereNotNull('rejected_at');
                        });
                })
                ->whereBetween('signature_date', [$myAuthority->from, $myAuthority->to]);

                $signedSignaturesFlows = $signedSignaturesFlows->unionAll($authoritiesSignedSignaturesFlows);
            }

            $signedSignaturesFlows = $signedSignaturesFlows->orderByDesc('id')->paginate(20);

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
        $request->validate([
            'distribution' => ['nullable', new CommaSeparatedEmails],
            'recipients' => ['nullable', new CommaSeparatedEmails]
        ]);

        DB::beginTransaction();

        try {
            $signature = new Signature($request->All());
            $signature->user_id = Auth::id();
            $signature->ou_id = Auth::user()->organizationalUnit->id;
            $signature->responsable_id = Auth::id();
            $signature->reserved = $request->input('reserved') == 'on' ? 1 : null;
            $signature->save();

            $signaturesFile = new SignaturesFile();
            $signaturesFile->signature_id = $signature->id;

            if ($request->file_base_64) {
                $documentFile = base64_decode($request->file_base_64);
                $signaturesFile->md5_file = $request->md5_file;
            } else {
                $documentFile = file_get_contents($request->file('document')->getRealPath());
                $signaturesFile->md5_file = md5_file($request->file('document'));
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

                    $signaturesFile->file_type = 'anexo';
                    $signaturesFile->save();

                    $documentFile = $annexed->openFile()->fread($documentFile->getSize());
                    //$filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
                    $filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.' . $annexed->extension();
                    $signaturesFile->update(['file' => $filePath,]);
                    Storage::disk('gcs')->put($filePath, $documentFile);
                }
            }

            $visatorTypes = null;
            if($request->has('visator_types')){
                $visatorTypes = unserialize($request->visator_types);
                $elaboradorCount = 0;
                $revisadorCount = 0;
            }

            if ($request->ou_id_signer != null) {
                $signaturesFlow = new SignaturesFlow();
                $signaturesFlow->signatures_file_id = $signaturesFileDocumentId;
                $signaturesFlow->type = 'firmante';
                $signaturesFlow->ou_id = $request->ou_id_signer;
                $signaturesFlow->user_id = $request->user_signer;
                $signaturesFlow->custom_x_axis = $request->custom_x_axis;
                $signaturesFlow->custom_y_axis = $request->custom_y_axis;
                if ($visatorTypes != null) {
                    $signaturesFlow->visator_type = 'aprobador';
                }
                $signaturesFlow->save();
            }

            if ($request->has('ou_id_visator'))
            {
                foreach ($request->ou_id_visator as $key => $ou_id_visator) {
                    $signaturesFlow = new SignaturesFlow();
                    $signaturesFlow->signatures_file_id = $signaturesFileDocumentId;
                    $signaturesFlow->type = 'visador';
                    $signaturesFlow->ou_id = $ou_id_visator;
                    $signaturesFlow->user_id = $request->user_visator[$key];
                    $signaturesFlow->sign_position = $key + 1;
                    if($visatorTypes != null) {
                        $signaturesFlow->visator_type = $visatorTypes[$key];
                        if($visatorTypes[$key] === 'elaborador') {
                            $elaboradorCount = $elaboradorCount +1;
                            $signaturesFlow->position_visator_type = $elaboradorCount;
                        }
                        else{
                            $revisadorCount = $revisadorCount +1;
                            $signaturesFlow->position_visator_type = $revisadorCount;
                        }
                    }
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
            } elseif ($signature->signaturesFlowVisator->where('sign_position', 1)->count() === 1) {
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
        // $destinatarios = $request->recipients;
        // $dest_vec = array_map('trim', explode(',', $destinatarios));
        // $cont=0;

        // foreach ($dest_vec as $dest) {
        //     if ($dest == 'director.ssi@redsalud.gob.cl' or $dest == 'director.ssi@redsalud.gov.cl' or $dest == 'director.ssi1@redsalud.gob.cl'and $cont===0)
        //     {
        //         $cont=$cont+1;
        //         $tipo = null;
        //         $generador = Auth::user()->full_name;
        //         $unidad = Auth::user()->organizationalUnit->name;

        //         switch ($request->document_type) {
        //             case 'Memorando':
        //                 $this->tipo = 'Memo';
        //                 break;
        //             case 'Resoluciones':
        //                 $this->tipo = 'Resolución';
        //                 break;
        //             default:
        //                 $this->tipo = $request->document_type;
        //                 break;
        //         }

        //         $parte = Parte::create([
        //             'entered_at' => Carbon::now(),
        //             'type' => $this->tipo,
        //             'date' => $request->request_date,
        //             'subject' => $request->subject,
        //             'origin' => $unidad . ' (Parte generado desde Solicitud de Firma N°' . $signature->id . ' por ' . $generador . ')',
        //         ]);

        //         $distribucion = SignaturesFile::where('signature_id', $signature->id)->where('file_type', 'documento')->get();
        //         ParteFile::create([
        //             'parte_id' => $parte->id,
        //             'file' => $distribucion->first()->file,
        //             'name' => $distribucion->first()->id . '.pdf',
        //             'signature_file_id' => $distribucion->first()->id,
        //         ]);

        //         $signaturesFiles = SignaturesFile::where('signature_id', $signature->id)->where('file_type', 'anexo')->get();
        //         foreach ($signaturesFiles as $key => $sf) {
        //             ParteFile::create([
        //                 'parte_id' => $parte->id,
        //                 'file' => $sf->file,
        //                 'name' => $sf->id . '.pdf',
        //                 //'signature_file_id' => $sf->id,
        //             ]);
        //         }
        //     }
        // }

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
        $request->validate([
            'distribution' => ['nullable', new CommaSeparatedEmails],
            'recipients' => ['nullable', new CommaSeparatedEmails]
        ]);

        $signature->fill($request->all());
        $signature->rejected_at = null;
        $signature->reserved = $request->input('reserved') == 'on' ? 1 : null;
        $signature->save();

        if ($request->hasFile('document')) {
            $signatureFileDocumento = $signature->signaturesFiles->where('file_type', 'documento')->first();

            Storage::disk('gcs')->delete($signatureFileDocumento->file);
            $documentFile = file_get_contents($request->file('document')->getRealPath());
            $filePath = 'ionline/signatures/original/' . $signatureFileDocumento->id . '.pdf';
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

                $signaturesFile->file_type = 'anexo';
                $signaturesFile->save();

                $documentFile = $annexed->openFile()->fread($documentFile->getSize());
                //$filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
                $filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.' . $annexed->extension();
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
                $signaturesFlow->save();
            }
        }

        $signatureFileDocumento->update(['signed_file' => null]);

        session()->flash('info', "Los datos de la firma $signature->id han sido actualizados.");
        return redirect()->route('documents.signatures.index', ['mis_documentos']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Signature $signature
     * @return RedirectResponse
     * @throws Exception
     * @throws Throwable
     */
    public function destroy(Signature $signature): RedirectResponse
    {
        DB::beginTransaction();

        try {
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

                // borro partes files y partes
                if ($signaturesFile->parteFile) {
                    $signaturesFile->parteFile->delete();
                    $signaturesFile->parteFile->event->delete();
                }
                $signaturesFile->delete();


            }
            $signature->delete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

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

    public function downloadAnexo(SignaturesFile $anexo)
    {
        return Storage::disk('gcs')->download($anexo->file);
    }


    public function verify(Request $request)
    {
        if ($request->id && $request->verification_code) {
            $signaturesFile = SignaturesFile::find($request->id);
            if ($signaturesFile->verification_code == $request->verification_code) {
                return Storage::disk('gcs')->response($signaturesFile->signed_file);
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
        $signatureFlow = SignaturesFlow::find($idSignatureFlow);
        $user_signer_id = $signatureFlow->user_id;
        $signatureFlow->update([
            'status' => 0,
            'observation' => $request->observacion,
            'real_signer_id' => (Auth::user()->id == $user_signer_id) ? null : Auth::user()->id,
        ]);
        $signatureFlow->signature()->update(['rejected_at' => now()]);

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


    public function massSignModal($pendingSignaturesFlowIds)
    {
        $pendingSignaturesFlowIdsArray = explode(',', $pendingSignaturesFlowIds);
        $pendingSignaturesFlows = SignaturesFlow::findMany($pendingSignaturesFlowIdsArray);

        return view('documents.signatures.partials.mass_sign_modal_content', compact('pendingSignaturesFlows'));
    }

}
