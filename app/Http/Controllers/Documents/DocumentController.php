<?php

namespace App\Http\Controllers\Documents;

use App\Models\Agreements\Addendum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
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
use App\Models\Rrhh\Authority;
use Illuminate\View\View;

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

        if (auth()->user()->organizational_unit_id) {
            $childs = array(auth()->user()->organizational_unit_id);

            $childs = array_merge($childs, auth()->user()->OrganizationalUnit->childs->pluck('id')->toArray());
            foreach (auth()->user()->OrganizationalUnit->childs as $child) {
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
                ->where('user_id', auth()->user()->id)
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
                ->where('user_id', '<>', auth()->user()->id)
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
    public function create(): View
    {
        $document = new Document();
        $types = Type::whereNull('partes_exclusive')->orderBy('name')->pluck('name','id');
        return view('documents.create', compact('document','types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFromTemplate($template = null): View
    {
        $document = new Document();
        $types = Type::whereNull('partes_exclusive')->orderBy('name')->pluck('name','id');
        $templates = [
            [
                'id' => 1,
                'title' => 'Message received',
                'content' => '<p dir="ltr">Hey {{usuario.nombre_completo}}!</p>
                    <p dir="ltr">Just a quick note to say we’ve received your message, and will get back to you within 48 hours.</p>
                    <p dir="ltr">For reference, your ticket number is: {{unidad.nombre}}</p>
                    <p dir="ltr">Should you have any questions in the meantime, just reply to this email and it will be attached to this ticket.</p>
                    <p><strong>&nbsp;</strong></p>
                    <p dir="ltr">Regards,</p>
                    <p dir="ltr">{{unidad.autoridad}}</p>'
            ],
            [
                'id' => 2,
                'title' => 'Thanks for the feedback',
                'content' => '<p dir="ltr">Hi {{usuario.nombre_completo}},</p>
                    <p dir="ltr">We appreciate you taking the time to provide feedback on {{unidad.nombre}}.</p>
                    <p dir="ltr">It sounds like it wasn’t able to fully meet your expectations, for which we apologize. 
                        Rest assured our team looks at each piece of feedback and uses it to decide what to focus on next with {{usuario.nombre_completo}}.</p>
                    <p dir="ltr"><strong>&nbsp;</strong></p>
                    <p dir="ltr">All the best, and let us know if there’s anything else we can do to help.</p>
                    <p dir="ltr">-{{unidad.autoridad}}</p>'
            ],
            [
                'id' => 3,
                'title' => 'Template con iteración',
                'content' => '
                    <p>Hola <strong>{{usuario.nombre_completo}}</strong></p>
                    <p>Esta es una nota r&aacute;pida de c&oacute;mo hacer una plantilla que tiene una iteraci&oacute;n.</p>

                    @if(usuario.premium)
                        <p>¡Gracias por ser un miembro premium!</p>
                    @else
                        <p>Considera unirte a nuestro programa premium para obtener más beneficios.</p>
                    @endif

                    <p>Usando tablas</p>
                    <table style="border-collapse: collapse; width: 100%;" border="1">
                        <colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>
                        <tbody>
                        <tr>
                            <td><strong>Nombre de la cuota</strong></td>
                            <td style="text-align: center;"><strong>Valor</strong></td>
                        </tr>
                        @foreach(cuotas)
                        <tr>
                            <td>{{cuotas.name}}</td>
                            <td style="text-align: center;">{{cuotas.valor}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <p>Usando Listas</p>
                    <ul>
                        @foreach(cuotas)
                            <li><b>{{cuotas.name}}</b>: {{cuotas.valor}}</li>
                        @endforeach
                    </ul>
                    <p>Atentamente,</p>
                    <p><strong>{{unidad.autoridad}}</strong><br><strong>{{unidad.nombre}}</strong></p>'
            ],
        ];

        $data['usuario']['nombre_completo'] = auth()->user()->full_name;
        $data['usuario']['premium'] = false;
        $data['unidad']['nombre'] = auth()->user()->organizationalUnit->name;
        $data['unidad']['autoridad'] = auth()->user()->boss->full_name;
        $data['cuotas'] = [
            ['name' => 'Cuota 1','valor' => 100],
            ['name' => 'Cuota 2','valor' => 200],
            ['name' => 'Cuota 3','valor' => 300]
        ];

        // Get the content of a template based on the id
        $template = collect($templates)->firstWhere('id', $template);

        function replaceTemplateVariables($templateContent, $data) {
        // Reemplazo de variables simples
            foreach ($data as $key => $values) {
                if (is_array($values) && isset($values[0]) && is_array($values[0])) {
                    // Manejar iteraciones
                    $pattern = '/@foreach\(' . $key . '\)(.*?)@endforeach/s';
                    while (preg_match($pattern, $templateContent, $matches)) {
                        $repeatedBlock = '';
                        foreach ($values as $item) {
                            $tempBlock = $matches[1];
                            foreach ($item as $subKey => $subValue) {
                                $tempBlock = str_replace('{{' . $key . '.' . $subKey . '}}', $subValue, $tempBlock);
                            }
                            $repeatedBlock .= $tempBlock;
                        }
                        $templateContent = str_replace($matches[0], $repeatedBlock, $templateContent);
                    }
                } else {
                    // Variables simples
                    foreach ($values as $subKey => $value) {
                        $templateContent = str_replace('{{' . $key . '.' . $subKey . '}}', $value, $templateContent);
                    }
                }
            }
            
            // Manejar condicionales
            $patternIf = '/@if\((.*?)\)(.*?)@else(.*?)@endif/s';
            while (preg_match($patternIf, $templateContent, $matches)) {
                $condition = $matches[1];
                $ifBlock = $matches[2];
                $elseBlock = $matches[3];

                // Evaluar condición (solo booleanas)
                $condition = str_replace(['usuario.premium'], [$data['usuario']['premium']], $condition);

                if (eval("return $condition;")) {
                    $templateContent = str_replace($matches[0], $ifBlock, $templateContent);
                } else {
                    $templateContent = str_replace($matches[0], $elseBlock, $templateContent);
                }
            }

            // Manejar condicionales sin else
            $patternIfNoElse = '/@if\((.*?)\)(.*?)@endif/s';
            while (preg_match($patternIfNoElse, $templateContent, $matches)) {
                $condition = $matches[1];
                $ifBlock = $matches[2];

                // Evaluar condición (solo booleanas)
                $condition = str_replace(['usuario.premium'], [$data['usuario']['premium']], $condition);

                if (eval("return $condition;")) {
                    $templateContent = str_replace($matches[0], $ifBlock, $templateContent);
                } else {
                    $templateContent = str_replace($matches[0], '', $templateContent);
                }
            }
            return $templateContent;
        }
        
        // Reemplazar las variables en el contenido del template
        $document->content = replaceTemplateVariables($template['content'], $data);
        // $document->content = $template['content'];
        
        // dd($template['content']);

        // http://localhost:8000/documents/create-from-template/1

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
        $document->user()->associate(auth()->user());
        $document->establishment()->associate(auth()->user()->organizationalUnit->establishment);
        $document->organizationalUnit()->associate(auth()->user()->organizationalUnit);
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
            if($document->type_id == Type::where('name','Resolución')->first()->id)
                $agreement->update(['res_document_id' => $document->id]);
            else
                $agreement->update(['document_id' => $document->id]);
        }

        if ($request->has('addendum_id')) {
            $addendum = Addendum::find($request->addendum_id);
            $addendum->update(['document_id' => $document->id]);
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
            $types = Type::whereNull('partes_exclusive')->orderBy('name')->pluck('name','id');
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

        if ($request->hasFile('file')) {
            $filename = $document->id . '-' .
                $document->type->name . '_' .
                $document->number . '.' .
                $request->file->getClientOriginalExtension();
            $document->file = $request->file->storeAs('ionline/documents/documents', $filename, ['disk' => 'gcs']);
        }

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

        return redirect()->route('documents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFromPrevious(Request $request)
    {
        $document = Document::findOrNew($request->document_id);
        if ($document->user_id != auth()->id()) {
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
        $ct = Document::whereRelation('organizationalUnit.establishment','id',auth()->user()->organizationalUnit->establishment_id)
            ->count();
    
        // Contar todos los documentos creados por usuarios
        $users = User::whereHas('documents')
            ->withCount('documents')
            ->whereRelation('organizationalUnit.establishment','id',auth()->user()->organizationalUnit->establishment_id)
            ->orderByDesc('documents_count')
            ->get();

        $ous = OrganizationalUnit::whereHas('documents')
            ->withCount('documents')
            ->where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->with('establishment')
            ->orderByDesc('documents_count')
            ->get();

        return view('documents.report', compact('ct','users','ous'));
    }

    public function sendForSignature(Document $document)
    {
        $signature = new Signature();
        $signature->request_date = now();
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
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO. ASESORIA JURIDICA - CARMEN HENRIQUEZ
            //                 ['ou_id' => 12, 'user_id' => 17289587] // DEPTO. APS - VALENTINA ORTEGA
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SDGA - CARLOS CALVO
            //                 ['ou_id' => 31, 'user_id' => 17432199], // DEPTO.GESTION FINANCIERA (40) - ROMINA GARÍN
                foreach(array(12834358, 17289587, 14104369, 17432199) as $user_id) //resto de visadores por cadena de responsabilidad
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
                $signature->recipients = 'blanca.galaz@redsalud.gob.cl';
            }
        }


        if($document->type_id == Type::where('name','Resolución Continuidad Convenio')->first()->id){
            $continuityResolution = ContinuityResolution::with('referrer')->where('document_id', $document->id)->first();
            $visadores = collect([$continuityResolution->referrer]); //referente tecnico
                        // $visadores = collect([
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO. ASESORIA JURIDICA - CAREMN HENRIQUEZ
            //                 ['ou_id' => 12, 'user_id' => 17289587] // DEPTO. APS - VALENTINA ORTEGA
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SDGA - CARLOS CALVO
            //                 ['ou_id' => 31, 'user_id' => 9994426], // SDA - JAIME ABARZUA
            //             ]);
            foreach(array(6811637, 17289587, 14104369, 9994426) as $user_id) //resto de visadores por cadena de responsabilidad
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
            $signature->recipients = 'blanca.galaz@redsalud.gob.cl';
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
            $signature->recipients = 'blanca.galaz@redsalud.gob.cl';
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
