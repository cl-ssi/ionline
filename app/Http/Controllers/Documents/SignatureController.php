<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Agreements\Addendum;
use App\Models\Agreements\Agreement;
use App\Models\Agreements\ContinuityResolution;
use App\Models\Documents\Document;
use App\Models\Documents\Parte;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\File;
use App\Models\Rrhh\Authority;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\User;
use App\Notifications\Documents\PendingSign;
use App\Notifications\Signatures\NewSignatureRequest;
use App\Rules\CommaSeparatedEmails;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
// use App\Models\Documents\ParteFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request, string $tab)
    {
        $search = "%$request->search%";
        $mySignatures = null;
        $signedSignaturesFlows = null;
        $pendingSignaturesFlows = null;
        $users[0] = auth()->id();

        if (auth()->user()->iAmSubrogantOf->count() > 0) {
            foreach (auth()->user()->getIAmSubrogantOfAttribute() as $surrogacy) {
                array_push($users, $surrogacy->id);
            }
        }

        $myAuthorities = collect();
        $ous_secretary = Authority::getAmIAuthorityFromOu(today(), 'secretary', auth()->id());
        foreach ($ous_secretary as $secretary) {
            if ($secretary->OrganizationalUnit) {
                $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, today(), 'manager')->user_id;
                $allTimeAuthorities = Authority::getAuthorityFromAllTime($secretary->OrganizationalUnit->id, 'manager');
            }
            //$users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, today(), 'manager')->user_id;

            /* TODO: @tebiccr Despues de que esté estable el modulo nueva autoridad quitar este foreach ya que no debería ser necesario */
            // foreach($allTimeAuthorities as $allTimeAuthority){
            //     if(!in_array($allTimeAuthority->user_id, $users)){
            //         $myAuthorities->push($allTimeAuthority);
            //     }
            // }
        }

        if ($tab == 'mis_documentos') {
            //Firmas del usuario y del manager actual de ou
            $mySignatures = Signature::with('signaturesFiles')
                ->whereIn('responsable_id', $users)
                ->where(function ($query) use ($request) {
                    $query->where('subject', 'LIKE', '%'.$request->search.'%')
                        ->orWhere('id', '=', $request->search)
                        ->orWhere('description', 'LIKE', '%'.$request->search.'%');
                });

            //Firmas de managers anteriores de la ou
            foreach ($myAuthorities as $myAuthority) {
                $authoritiesSignatures = Signature::where('responsable_id', $myAuthority->user_id)
                    ->whereBetween('created_at', [$myAuthority->from, $myAuthority->to])
                    ->where(function ($query) use ($request, $search) {
                        $query->where('subject', 'like', $search)
                            ->orWhere('id', '=', $request->search)
                            ->orWhere('description', 'like', $search);
                    });

                $mySignatures = $mySignatures->unionAll($authoritiesSignatures);
            }
            $mySignatures = $mySignatures->orderByDesc('id')->paginate(20);
        }

        if ($tab == 'pendientes') {
            //Firmas del usuario y del manager actual de ou
            $pendingSignaturesFlows = SignaturesFlow::with('signaturesFile', 'userSigner')
                ->whereIn('user_id', $users)
                ->whereNull('status')
                ->whereHas('signaturesFile.signature', function ($q) {
                    $q->whereNull('rejected_at');
                })

                ->when($request->search, function ($query) use ($search, $request) {
                    $query->whereHas('signaturesFile.signature', function ($query) use ($search, $request) {
                        $query->where('subject', 'like', $search)
                            ->orWhere('id', '=', $request->search)
                            ->orWhere('description', 'like', $search);
                    });
                });

            //Firmas de managers anteriores de la ou
            foreach ($myAuthorities as $myAuthority) {
                $authoritiesPendingSignaturesFlows = SignaturesFlow::where('user_id', $myAuthority->user_id)
                    ->whereNull('status')
                    ->whereHas('signaturesFile.signature', function ($q) {
                        $q->whereNull('rejected_at');
                    })
                    ->whereBetween('signature_date', [$myAuthority->from, $myAuthority->to])
                    ->whereHas('signaturesFile.signature', function ($q) use ($request) {
                        $q->where('subject', 'LIKE', '%'.$request->search.'%')
                            ->orWhere('id', '=', $request->search)
                            ->orWhere('description', 'LIKE', '%'.$request->search.'%');
                    });

                $pendingSignaturesFlows = $pendingSignaturesFlows->unionAll($authoritiesPendingSignaturesFlows);
            }

            $pendingSignaturesFlows = $pendingSignaturesFlows->get();

            //Firmas del usuario y del manager actual de ou

            $signedSignaturesFlows = SignaturesFlow::with('signaturesFile', 'userSigner')
                ->whereIn('user_id', $users)
                ->where(function ($q) {
                    $q->whereNotNull('status')
                        ->orWhereHas('signaturesFile.signature', function ($q) {
                            $q->whereNotNull('rejected_at');
                        });
                })
                ->when($request->search, function ($query) use ($search, $request) {
                    $query->whereHas('signaturesFile.signature', function ($query) use ($search, $request) {
                        $query->where('subject', 'like', $search)
                            ->orWhere('id', '=', $request->search)
                            ->orWhere('description', 'like', $search);
                    });
                });

            //Firmas de managers anteriores de la ou
            foreach ($myAuthorities as $myAuthority) {
                $authoritiesSignedSignaturesFlows = SignaturesFlow::where('user_id', $myAuthority->user_id)
                    ->where(function ($q) {
                        $q->whereNotNull('status')
                            ->orWhereHas('signaturesFile.signature', function ($q) {
                                $q->whereNotNull('rejected_at');
                            });
                    })
                    ->whereBetween('signature_date', [$myAuthority->from, $myAuthority->to])
                    ->whereHas('signaturesFile.signature', function ($q) use ($request) {
                        $q->where('subject', 'LIKE', '%'.$request->search.'%')
                            ->orWhere('id', '=', $request->search)
                            ->orWhere('description', 'LIKE', '%'.$request->search.'%');
                    });

                $signedSignaturesFlows = $signedSignaturesFlows->unionAll($authoritiesSignedSignaturesFlows);
            }

            $signedSignaturesFlows = $signedSignaturesFlows->when($request->search, function ($query) use ($search, $request) {
                $query->whereHas('signaturesFile.signature', function ($query) use ($search, $request) {
                    $query->where('subject', 'like', $search)
                        ->orWhere('id', '=', $request->search)
                        ->orWhere('description', 'like', $search);
                });
            });

            $signedSignaturesFlows = $signedSignaturesFlows->orderByDesc('id')->paginate(25);

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
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'distribution' => ['nullable', new CommaSeparatedEmails],
            'recipients' => ['nullable', new CommaSeparatedEmails],
        ]);

        DB::beginTransaction();

        try {
            $signature = new Signature($request->All());
            $signature->status = 'pending';
            $signature->user_id = Auth::id();
            $signature->ou_id = auth()->user()->organizationalUnit->id;
            $signature->responsable_id = Auth::id();
            $signature->reserved = $request->input('reserved') == 'on' ? 1 : null;
            $signature->save();

            $signaturesFile = new SignaturesFile;
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

            $filePath = 'ionline/signatures/original/'.$signaturesFileDocumentId.'.pdf';
            $signaturesFile->update(['file' => $filePath]);
            Storage::disk('gcs')->put($filePath, $documentFile);

            if ($request->annexed) {
                foreach ($request->annexed as $key => $annexed) {
                    $signaturesFile = new SignaturesFile;
                    $signaturesFile->signature_id = $signature->id;
                    $documentFile = $annexed;

                    $signaturesFile->file_type = 'anexo';
                    $signaturesFile->save();

                    $documentFile = $annexed->openFile()->fread($documentFile->getSize());
                    //$filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
                    $filePath = 'ionline/signatures/original/'.$signaturesFile->id.'.'.$annexed->extension();
                    $signaturesFile->update(['file' => $filePath]);
                    Storage::disk('gcs')->put($filePath, $documentFile);
                }
            }

            $visatorTypes = null;
            if ($request->has('visator_types')) {
                $visatorTypes = unserialize($request->visator_types);
                $elaboradorCount = 0;
                $revisadorCount = 0;
            }

            if ($request->ou_id_signer != null) {
                $signaturesFlow = new SignaturesFlow;
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

            if ($request->has('ou_id_visator')) {
                foreach ($request->ou_id_visator as $key => $ou_id_visator) {
                    $signaturesFlow = new SignaturesFlow;
                    $signaturesFlow->signatures_file_id = $signaturesFileDocumentId;
                    $signaturesFlow->type = 'visador';
                    $signaturesFlow->ou_id = $ou_id_visator;
                    $signaturesFlow->user_id = $request->user_visator[$key];
                    $signaturesFlow->sign_position = $key + 1;
                    if ($visatorTypes != null) {
                        $signaturesFlow->visator_type = $visatorTypes[$key];
                        if ($visatorTypes[$key] === 'elaborador') {
                            $elaboradorCount = $elaboradorCount + 1;
                            $signaturesFlow->position_visator_type = $elaboradorCount;
                        } else {
                            $revisadorCount = $revisadorCount + 1;
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

            if ($request->has('continuity_resol_id')) {
                $continuityResolution = ContinuityResolution::find($request->continuity_resol_id);
                $request->signature_type == 'visators' ? $continuityResolution->update(['file_to_endorse_id' => $signaturesFileDocumentId, 'file_to_sign_id' => null]) : $continuityResolution->update(['file_to_sign_id' => $signaturesFileDocumentId]);
            }

            // dd();
            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        //Envía los correos correspondientes
        if ($request->endorse_type != 'Visación en cadena de responsabilidad') {
            foreach ($signature->signaturesFlows as $signaturesFlow) {
                /** Enviar mail de notificación de nuevo documento para firmar */
                $signaturesFlow->userSigner->notify(new NewSignatureRequest($signature));
            }
        } elseif ($signature->signaturesFlowVisator->where('sign_position', 1)->count() === 1) {
            $firstVisatorFlow = $signature->signaturesFlowVisator->where('sign_position', 1)->first();
            /** Enviar mail de notificación de nuevo documento para firmar */
            $firstVisatorFlow->userSigner->notify(new NewSignatureRequest($signature));
        } elseif ($signature->signaturesFlowSigner) {
            /** Enviar mail de notificación de nuevo documento para firmar */
            $signature->signaturesFlowSigner->userSigner->notify(new NewSignatureRequest($signature));
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
        //         $generador = auth()->user()->full_name;
        //         $unidad = auth()->user()->organizationalUnit->name;

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

        session()->flash('info', 'La solicitud de firma '.$signature->id.' ha sido creada.');

        return redirect()->route('documents.signatures.index', ['mis_documentos']);
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Signature $signature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View|Response
     */
    public function edit(Signature $signature)
    {
        return view('documents.signatures.edit', compact('signature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Exception
     */
    public function update(Request $request, Signature $signature): RedirectResponse
    {
        $request->validate([
            'distribution' => ['nullable', new CommaSeparatedEmails],
            'recipients' => ['nullable', new CommaSeparatedEmails],
        ]);

        $signature->fill($request->all());
        $signature->rejected_at = null;
        $signature->reserved = $request->input('reserved') == 'on' ? 1 : null;
        $signature->save();

        if ($request->hasFile('document')) {
            $signatureFileDocumento = $signature->signaturesFiles->where('file_type', 'documento')->first();

            Storage::disk('gcs')->delete($signatureFileDocumento->file);
            $documentFile = file_get_contents($request->file('document')->getRealPath());
            $filePath = 'ionline/signatures/original/'.$signatureFileDocumento->id.'.pdf';
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
                $signaturesFile = new SignaturesFile;
                $signaturesFile->signature_id = $signature->id;
                $documentFile = $annexed;

                $signaturesFile->file_type = 'anexo';
                $signaturesFile->save();

                $documentFile = $annexed->openFile()->fread($documentFile->getSize());
                //$filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
                $filePath = 'ionline/signatures/original/'.$signaturesFile->id.'.'.$annexed->extension();
                $signaturesFile->update(['file' => $filePath]);
                Storage::disk('gcs')->put($filePath, $documentFile);
            }
        }

        //borrar y crea nuevos flows
        $signatureFileDocumento = $signature->signaturesFiles->where('file_type', 'documento')->first();
        $signatureFileDocumento->signaturesFlows()->delete();

        if ($request->ou_id_signer != null) {
            $signaturesFlow = new SignaturesFlow;
            $signaturesFlow->signatures_file_id = $signatureFileDocumento->id;
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->ou_id = $request->ou_id_signer;
            $signaturesFlow->user_id = $request->user_signer;
            $signaturesFlow->save();
        }

        if ($request->has('ou_id_visator')) {
            foreach ($request->ou_id_visator as $key => $ou_id_visator) {
                $signaturesFlow = new SignaturesFlow;
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

                // borro files asociados
                if ($signaturesFile->parte) {
                    if ($signaturesFile->parte->files) {
                        $signaturesFile->parte->files()->delete();
                    }

                    // si no tiene sgr asociado, se permite la eliminación del parte.
                    if ($signaturesFile->parte->requirements->isEmpty()) {
                        $signaturesFile->parte->delete();
                    }
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
                if (Storage::disk('gcs')->exists($signaturesFile->signed_file)) {
                    return Storage::disk('gcs')->response($signaturesFile->signed_file);
                } else {
                    return "El archivo de la solicitud de firma {$signaturesFile->signature->id} fue borrado.<br>
                    Es posible que <b>{$signaturesFile->signature->user->shortName} </b>
                    deba crear una nueva solicitud.";
                }
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

    public function callbackFirma($message, $modelId, ?SignaturesFile $signaturesFile = null)
    {
        $fulfillment = Fulfillment::find($modelId);

        if (! $signaturesFile) {
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
        $signatureFlow = SignaturesFlow::withTrashed()->find($idSignatureFlow);
        if ($signatureFlow->trashed()) {
            session()->flash('danger', 'No se pudo rechazar la solicitud de firma, el creador la eliminó');
        } else {
            $user_signer_id = $signatureFlow->user_id;
            $signatureFlow->update([
                'status' => 0,
                'observation' => $request->observacion,
                'real_signer_id' => (auth()->id() == $user_signer_id) ? null : auth()->id(),
            ]);
            $signatureFlow->signature()->update([
                'status' => 'rejected',
                'rejected_at' => now(),
            ]);
        }

        session()->flash('success', 'La solicitud ha sido rechazada');

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

    public function notificationPending($signatureId)
    {

        $signature = Signature::findOrFail($signatureId);

        $pendingFlows = $signature->pendingSignaturesFlows();

        foreach ($pendingFlows as $pendingFlow) {
            $user = $pendingFlow->userSigner;
            $user->notify(new PendingSign($signature));
        }

        return redirect()->route('documents.signatures.index', ['pendientes'])
            ->with('success', 'Notificación enviada correctamente');
    }
}
