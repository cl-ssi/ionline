<?php

namespace App\Http\Controllers\Documents;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\Documents\Type;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\Signature;
use App\Models\Documents\Document;
use App\Models\Documents\Correlative;
use App\Mail\SendDocument;
use App\Http\Controllers\Controller;
use App\Models\Agreements\Agreement;
use App\Models\Agreements\BudgetAvailability;
use App\Models\Agreements\ContinuityResolution;
use App\Models\Documents\SignaturesFlow;
use App\Models\Parameters\Parameter;
use App\Rrhh\Authority;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$users = User::Search($request->get('name'))->orderBy('name','Asc')->paginate(30);
        //$documents = Document::Search($request)->latest()->paginate(50);

        $request->flash();

        $types = Type::whereNull('partes_exclusive')->pluck('name','id');

        if (Auth()->user()->organizational_unit_id) {
            $childs = array(Auth()->user()->organizational_unit_id);

            $childs = array_merge($childs, Auth()->user()->OrganizationalUnit->childs->pluck('id')->toArray());
            foreach (Auth()->user()->OrganizationalUnit->childs as $child) {
                $childs = array_merge($childs, $child->childs->pluck('id')->toArray());
            }

            $ownDocuments = Document::with(
                'user',
                'type',
                'user.organizationalUnit',
                'organizationalUnit',
                'fileToSign',
                'fileToSign.signaturesFlows'
                )
                ->Search($request)
                ->latest()
                ->where('user_id', Auth()->user()->id)
                //->whereIn('organizational_unit_id',$childs)
                // ->withTrashed()
                ->paginate(100);

            $otherDocuments = Document::with(
                'user',
                'type',
                'user.organizationalUnit',
                'organizationalUnit',
                'fileToSign',
                'fileToSign.signaturesFlows'
                )
                ->Search($request)
                ->latest()
                ->where('user_id', '<>', Auth()->user()->id)
                ->whereRelation('type','reserved', null)
                ->whereIn('organizational_unit_id', $childs)
                // ->withTrashed()
                ->paginate(100);

            return view('documents.index', compact('ownDocuments', 'otherDocuments', 'types'));
        }
        else {
            return redirect()->back()->with('danger', 'Usted no posee asignada una unidad organizacional favor contactar a su administrador');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $document = new Document();
        $types = Type::whereNull('partes_exclusive')->pluck('name','id');
        return view('documents.create', compact('document','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $document = new Document($request->All());
        $document->user()->associate(Auth::user());
        $document->establishment()->associate(auth()->user()->organizationalUnit->establishment);
        $document->organizationalUnit()->associate(Auth::user()->organizationalUnit);
        $document->reserved = $request->input('reserved') == 'on' ? 1 : null;
        $document->save();

        if ($request->has('continuity_resol_id')) {
            $continuityResolution = ContinuityResolution::find($request->continuity_resol_id);
            $continuityResolution->update(['document_id' => $document->id]);
        }

        if ($request->has('budget_availability_id')) {
            $budgetAvailability = BudgetAvailability::find($request->budget_availability_id);
            $budgetAvailability->update(['document_id' => $document->id]);
        }

        if ($request->has('agreement_id')) {
            $agreement = Agreement::find($request->agreement_id);
            $agreement->update(['document_id' => $document->id]);
        }

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        /** Vista demo para firmas */
        if($document->id == 13667) {
            return view('documents.templates.show_13667')->withDocument($document);
        }

        return Pdf::loadView('documents.templates.'.$document->viewName, [
            'document' => $document
        ])->stream('download.pdf');

        // return view('documents.templates.'.$document->viewName)->withDocument($document);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        /* Si tiene número de parte entonces devuelve al index */
        if ($document->file) {
            session()->flash('danger', 'Lo siento, el documento ya tiene un archivo adjunto');
            return redirect()->route('documents.index');
        }
        /* De lo contrario retorna para editar el documento */
        else {
            $types = Type::whereNull('partes_exclusive')->pluck('name','id');
            return view('documents.edit', compact('document','types'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $document->fill($request->all());
        $document->reserved = $request->input('reserved') == 'on' ? 1 : null;
        $document->save();

        session()->flash('info', 'El documento ha sido actualizado.
            <a href="' . route('documents.show', $document->id) . '" target="_blank">
            Previsualizar</a>');

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function deleteFile(Document $document)
    {
        Storage::disk('gcs')->delete($document->file);

        $document->file = null;
        $document->save();

        session()->flash('success', 'El archivo ha sido eliminado');
        return redirect()->route('documents.index');
    }

    public function addNumber()
    {
        return view('documents.add_number');
    }

    public function find(Request $request)
    {
        $document = Document::query()
            ->whereId($request->id)
            ->whereEstablishmentId( auth()->user()->organizationalUnit->establishment->id)
            ->first();
        return view('documents.add_number', compact('document'));
    }

    public function storeNumber(Request $request, Document $document)
    {
        $document->fill($request->all());

        if ($request->hasFile('file')) {
            $filename = $document->id . '-' .
                $document->type->name . '_' .
                $document->number . '.' .
                $request->file->getClientOriginalExtension();
            $document->file = $request->file->storeAs('ionline/documents/documents', $filename, ['disk' => 'gcs']);
        }
        $document->save();
        //unset($document->number);

        session()->flash('info', 'El documento ha sido actualizado.
            <a href="' . route('documents.show', $document->id) . '" target="_blank">
            Previsualizar</a>');

        if ($request->has('sendMail')) {
            /* Enviar a todos los email que aparecen en distribución */
            preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $document->distribution, $emails);
            //dd($emails[0]);
            Mail::to($emails[0])->send(new SendDocument($document));
        }

        return redirect()->route('documents.partes.outbox');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFromPrevious(Request $request)
    {
        $document = Document::findOrNew($request->document_id);
        $document->type_id = null;
        if ($document->user_id != Auth::id()) {
            $document = new Document();
        }
        $types = Type::whereNull('partes_exclusive')->pluck('name','id');

        return view('documents.create', compact('document','types'));
    }

    public function download(Document $document)
    {
        $filename = $document->type->name . ' ' .
            $document->number . '.' .
            File::extension($document->file);
        return Storage::disk('gcs')->response($document->file, $filename);
    }

    public function report()
    {
        $users = User::orderBy('name')->has('documents')->with('documents')->get();
        $ct = Document::count();
        $ous = OrganizationalUnit::has('documents')->get();
        return view('documents.report', compact('users', 'ct', 'ous'));
    }

    public function sendForSignature(Document $document)
    {
        $signature = new Signature();
        $signature->request_date = Carbon::now();
        $signature->subject = $document->subject;
        $signature->description = $document->antecedent;
        $signature->distribution = $document->distribution;
        $signature->type_id = $document->type_id;

        /** Cargar la imágen en base 64, ya que al generar el PDF no aparece */
        $image = base64_encode(file_get_contents(public_path('/images/logo_rgb.png')));

        /** Crear un pdf en base a una vista */
        $documentFile = \PDF::loadView('documents.templates.'.$document->viewName, compact('document','image'));

        $signaturesFile = new SignaturesFile();
        $signaturesFile->file = base64_encode($documentFile->output());
        $signaturesFile->file_type = 'documento';
        $signaturesFile->md5_file = md5($documentFile->output());

        $signature->signaturesFiles->add($signaturesFile);
        $documentId = $document->id;

        if($document->type_id == Type::where('name','Convenio')->first()->id){
            $agreement = Agreement::with('referrer')->where('document_id', $document->id)->first();
            if($agreement){
                $visadores = collect([$agreement->referrer]); //referente tecnico
                            // $visadores = collect([
                //                 ['ou_id' => 12, 'user_id' => 17289587] // DEPTO. APS - VALENTINA ORTEGA
                //                 ['ou_id' => 2, 'user_id' => 14104369], // SDGA - CARLOS CALVO
                //             ]);
                foreach(array(17289587, 14104369) as $user_id) //resto de visadores por cadena de responsabilidad
                    $visadores->add(User::find($user_id));
                
                foreach($visadores as $key => $visador){
                    $signaturesFlow = new SignaturesFlow();
                    $signaturesFlow->type = 'visador';
                    $signaturesFlow->ou_id = $visador->organizational_unit_id;
                    $signaturesFlow->user_id = $visador->id;
                    $signaturesFlow->sign_position = $key;
                    $signaturesFile->signaturesFlows->add($signaturesFlow);
                }

                $signature->description = $document->subject;
                $signature->endorse_type = 'Visación en cadena de responsabilidad';
                $signature->distribution = 'blanca.galaz@redsalud.gob.cl';
            }
        }


        if($document->type_id == Type::where('name','Resolución Continuidad Convenio')->first()->id){
            $continuityResolution = ContinuityResolution::with('referrer')->where('document_id', $document->id)->first();
            $visadores = collect([$continuityResolution->referrer]); //referente tecnico
                        // $visadores = collect([
            //                 ['ou_id' => 12, 'user_id' => 17289587] // DEPTO. APS - VALENTINA ORTEGA
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SDGA - CARLOS CALVO
            //                 ['ou_id' => 31, 'user_id' => 9994426], // SDA - JAIME ABARZUA
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO. ASESORIA JURIDICA - CARMEN HENRIQUEZ OLIVARES
            //             ]);
            foreach(array(17289587, 14104369, 9994426, 6811637) as $user_id) //resto de visadores por cadena de responsabilidad
                $visadores->add(User::find($user_id));
            
            foreach($visadores as $key => $visador){
                $signaturesFlow = new SignaturesFlow();
                $signaturesFlow->type = 'visador';
                $signaturesFlow->ou_id = $visador->organizational_unit_id;
                $signaturesFlow->user_id = $visador->id;
                $signaturesFlow->sign_position = $key;
                $signaturesFile->signaturesFlows->add($signaturesFlow);
            }

            $signature->description = $document->subject;
            $signature->endorse_type = 'Visación en cadena de responsabilidad';
            $signature->distribution = 'blanca.galaz@redsalud.gob.cl';
        }

        if($document->type_id == Type::where('name','Certificado Disponibilidad Presupuestaria')->first()->id){
            $budgetAvailability = BudgetAvailability::where('document_id', $document->id)->first();
            
            // $signaturesFlow = new SignaturesFlow();
            // $signaturesFlow->type = 'signer';
            // $signaturesFlow->ou_id = Parameter::get('ou', 'FinanzasSSI');
            // $signaturesFlow->user_id = Authority::getTodayAuthorityManagerFromDate($signaturesFlow->ou_id);
            // $signaturesFlow->sign_position = 0;
            // $signaturesFile->signaturesFlows->add($signaturesFlow);

            $signature->type = 'signer';
            $signature->ou_id = Parameter::get('ou', 'FinanzasSSI');
            // $signature->user_id = Authority::getTodayAuthorityManagerFromDate($signature->ou_id);
            $signature->description = $document->subject;
            $signature->endorse_type = 'No requiere visación';
            $signature->distribution = 'blanca.galaz@redsalud.gob.cl';
        }
    
        return view('documents.signatures.create', compact('signature', 'documentId'));
    }

    public function sendForSign(Document $document)
    {
        return view('documents.send-for-sign', compact('document'));
    }

    public function showDocument(Document $document)
    {
        $image = base64_encode(file_get_contents(public_path('/images/logo_rgb.png')));

        $documentFile = \PDF::loadView('documents.templates.'.$document->viewName, compact('document','image'));

        return $documentFile->stream();
    }

    public function signedDocumentPdf($id)
    {
        $document = Document::find($id);
        return Storage::disk('gcs')->response($document->fileToSign->signed_file);
        //        header('Content-Type: application/pdf');
        //        if (isset($document->fileToSign)) {
        //            echo base64_decode($document->fileToSign->signed_file);
        //        }
    }

}
