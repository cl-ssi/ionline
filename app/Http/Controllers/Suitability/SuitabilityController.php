<?php

namespace App\Http\Controllers\Suitability;


use App\Http\Controllers\Controller;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Suitability\Result;
use App\Models\Suitability\Signer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Suitability\PsiRequest;
use App\Models\Suitability\School;
use App\Models\UserExternal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;
use App\Mail\NewPsiRequest;
use App\Models\Documents\Type;
use Illuminate\Support\Facades\Mail;
use App\Models\Rrhh\Authority;

class SuitabilityController extends Controller
{
    //

    public function index(Request $request)
    {
        //return view('replacement_staff.index', compact('request'));
    }

    public function report(Request $request)
    {
        $dataArray = [];
        $schools = School::orderBy('name', 'asc')->get();
        $result = Result::has('signedCertificate')->with('psirequest');
        $month = $request->month;
        $years = $request->year; // Ahora esto es un array de años
        $sumesperando = 0;
        $sumfinalizado = 0;
        $sumaprobado = 0;
    
        if (!empty($years)) {
            foreach ($schools as $school) {
                $counteraprobado = PsiRequest::where('school_id', $school->id)
                    ->where('status', 'Aprobado')
                    ->whereIn(DB::raw('YEAR(created_at)'), $years)
                    ->when($month != 'Todos', function ($q) use ($month) {
                        return $q->whereMonth('created_at', '=', $month);
                    })
                    ->count();
    
                $counteresperando = PsiRequest::where('school_id', $school->id)
                    ->where('status', 'Esperando Test')
                    ->whereIn(DB::raw('YEAR(created_at)'), $years)
                    ->when($month != 'Todos', function ($q) use ($month) {
                        return $q->whereMonth('created_at', '=', $month);
                    })
                    ->count();
    
                $counterfinalizado = PsiRequest::where('school_id', $school->id)
                    ->where('status', 'Test Finalizado')
                    ->whereIn(DB::raw('YEAR(created_at)'), $years)
                    ->when($month != 'Todos', function ($q) use ($month) {
                        return $q->whereMonth('created_at', '=', $month);
                    })
                    ->count();
    
                $sumaprobado += $counteraprobado;
                $sumesperando += $counteresperando;
                $sumfinalizado += $counterfinalizado;
    
                if ($counteraprobado >= 1 || $counteresperando >= 1 || $counterfinalizado >= 1) {
                    array_push(
                        $dataArray,
                        [
                            'name_school' => $school->name,
                            'counteraprobado' => $counteraprobado,
                            'counteresperando' => $counteresperando,
                            'counterfinalizado' => $counterfinalizado,
                            'sumaprobado' => $sumaprobado,
                            'sumesperando' => $sumesperando,
                            'sumfinalizado' => $sumfinalizado,
                        ]
                    );
                }
            }
        }
    
        return view('suitability.report', compact('dataArray', 'request'));
    }
    

    public function reportsigned(Request $request)
    {

        $dataArray = array();
        $schools = School::orderBy('name', 'asc')->get();
        $month = $request->month;
        $sumfinalizado = 0;

        $results = Result::has('signedCertificate')->with('psirequest')->get();
        $cont = 0;

        foreach ($schools as $school) {
            foreach ($results as $result) {
                dump($result->signedCertificate->signaturesFlows->last());
            }
        }


        return view('suitability.reportsigned', compact('request'));
    }

    public function reportAllRequest(Request $request)
    {

        $desde = $request->input('from');
        $hasta = $request->input('to');
    
        $psirequests = PsiRequest::whereBetween('created_at', [$desde, $hasta])->get();
        return view('suitability.report.request', compact('request','psirequests'));
    }


    public function effective(Request $request)
    {

        $desde = $request->input('from');
        $hasta = $request->input('to');
    
        $psirequests = PsiRequest::whereBetween('created_at', [$desde, $hasta])->get();
        return view('suitability.report.request', [
            'request' => $request,
            'psirequests' => $psirequests,
            'route' => route('suitability.reports.effective'),
            'includeTrashed' => false,
        ]);
    }


    public function effectiveWithTrashed(Request $request)
    {

        $desde = $request->input('from');
        $hasta = $request->input('to');
    
        $psirequests = PsiRequest::withTrashed()
        ->whereBetween('created_at', [$desde, $hasta])
        ->get();        
        
        return view('suitability.report.request', [
            'request' => $request,
            'psirequests' => $psirequests,
            'route' => route('suitability.reports.effectiveWithTrashed'),
            'includeTrashed' => true,
        ]);
    }



    public function createExternal(School $school)
    {

        return view('external.suitability.create', compact('school'));
    }

    public function listOwn(School $school)
    {


        return view('external.suitability.index', compact('school'));
    }


    public function pending(Request $request)
    {

        $school_id = $request->colegio;
        $schools = School::orderBy("name", "asc")->get();
        $psirequests = PsiRequest::where('status', 'Test Finalizado')
            ->when($school_id != null, function ($q) use ($school_id) {
                return $q->where('school_id', $school_id);
            })
            ->paginate(100);
        return view('suitability.pending', compact('psirequests', 'schools', 'school_id'));
    }

    public function approved()
    {
        $psirequests = PsiRequest::where('status', 'Aprobado')->paginate(100);


        return view('suitability.approved', compact('psirequests'));
    }

    public function rejected()
    {
        $psirequests = PsiRequest::where('status', 'Rechazado')->get();
        return view('suitability.rejected', compact('psirequests'));
    }

    public function destroy(PsiRequest $psirequest)
    {
        $psirequest->delete();
        session()->flash('danger', 'La solicitud de idoneidad ha sido eliminado');
        return redirect()->back();
    }

    public function finalresult(PsiRequest $psirequest, $result)
    {

        $psirequest->status = $result;
        $psirequest->save();
        $signatureId =  $this->sendForSignature($psirequest->result()->first()->id);
        session()->flash('success', "Se dio resultado de manera correcta y se creó solicitud de firma $signatureId");

        return redirect()->back();
    }
    public function emergency(PsiRequest $psirequest)
    {
        // Obtener el resultado asociado al psirequest
        $result = $psirequest->result;

        // Obtener el signedCertificate correspondiente
        $signedCertificate = $result->signedCertificate;

        if ($signedCertificate) {
            // Obtener los flujos de firma asociados al signedCertificate
            $signaturesFlows = $signedCertificate->signaturesFlows;

            // Eliminar los flujos de firma
            foreach ($signaturesFlows as $flow) {
                $flow->delete();
            }

            // Eliminar el signedCertificate
            $signedCertificate->delete();
        }

        // Dejar en null el signed_certificate_id del resultado
        $result->signed_certificate_id = null;
        $result->save();

        // Se realiza nuevamente el proceso de firma

        $signatureId =  $this->sendForSignature($psirequest->result()->first()->id);
        session()->flash('success', "Se elimino el certificado  de manera correcta y se creó una nueva solicitud de firma $signatureId");
        return redirect()->back();
    }




    public function indexOwn(Request $request)
    {
        $selectedYear = $request->yearFilter ?? 'todos';
        $school_id = $request->colegio;
        $search = $request->search;
        $selectedYear = $request->yearFilter ?? 'todos';
        $psirequests_count = PsiRequest::count();
        
        $psirequests = PsiRequest::with(['school', 'user'])
            ->when($school_id != null, function ($q) use ($school_id) {
                return $q->where('school_id', $school_id);
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('fathers_family', 'like', '%' . $search . '%')
                        ->orWhere('mothers_family', 'like', '%' . $search . '%');
                });
            })
            ->when($selectedYear !== 'todos', function ($q) use ($selectedYear) {
                return $q->whereYear('created_at', $selectedYear);
            })
            ->paginate(100);
    
        if ($school_id != null or $search != null or $selectedYear !== 'todos') {
            $psirequests_count = $psirequests->count();
        }
    
        $schools = School::orderBy("name", "asc")->get();
        return view('suitability.indexown', compact('psirequests', 'schools', 'school_id', 'psirequests_count', 'search', 'selectedYear', 'request'));
    }
    
    


    public function validateRequest()
    {
        return view('suitability.validaterequest');
    }

    public function validateRun(Request $request)
    {
        $user = User::find($request->run);
        // if(!$user)
        // {
        //     return redirect()->route('suitability.create',$request->run);


        // }
        // else
        // {
        //     dd("Si existe");
        // }
        return redirect()->route('suitability.create', $request->run);
    }



    public function create($run)
    {
        $user = User::firstOrNew(['id' => $run]);
        return view('suitability.create', compact('run', 'user'));
    }
    public function storeSuitabilityExternal(Request $request)
    {
        $userexternal = new UserExternal($request->All());
        if (UserExternal::find(request('id'))) {
            $userexternal->update();
        } else {
            $userexternal->save();
        }
        $psirequest = new PsiRequest();
        $psirequest->job = $request->input('job');
        $psirequest->country = $request->input('country');
        $psirequest->start_date = $request->input('start_date');
        $psirequest->disability = $request->input('disability');
        $psirequest->status = "Esperando Test";
        $psirequest->user_external_id = $request->input('id');
        $psirequest->user_creator_id = Auth::guard('external')->user()->id;
        $psirequest->school_id = $request->input('school_id');
        $psirequest->save();
        Mail::to('maria.zuniga@redsalud.gob.cl')
            // Mail::to('tebiccr@gmail.com')
            ->send(new NewPsiRequest($psirequest));


        session()->flash('success', 'Solicitud Creada Exitosamente, ahora el asistente puede ingresar a este mismo sitio con los datos de clave única a realizar la prueba');
        return redirect()->route('external');
    }

    public function store(Request $request)
    {
        $user = new User($request->All());
        $user->email_personal = $request->email;
        $user->external = 1;
        $user->givePermissionTo('Suitability: test');
        if (User::find(request('id'))) {
            $user->update();
        } else {
            $user->password = bcrypt('123456');
            $user->save();
        }

        $psirequest = new PsiRequest();
        $psirequest->job = $request->input('job');
        $psirequest->country = $request->input('country');
        $psirequest->start_date = $request->input('start_date');
        $psirequest->disability = $request->input('disability');
        $psirequest->status = "Esperando Test";
        $psirequest->user_id = $request->input('id');
        $psirequest->user_creator_id = Auth::id();
        $psirequest->save();

        session()->flash('success', 'Solicitud Creada Exitosamente');

        return redirect()->route('suitability.own');
    }

    /**
     * @throws Throwable
     */
    public function sendForSignature($id)
    {
        $result = Result::find($id);
        $pdf = \PDF::loadView('suitability.results.certificate', compact('result'));

        //Firmante
        // $userSigner = Authority::getAuthorityFromDate(44, today(), 'manager')->user; //Subdirección Gestión y Desarrollo de las Personas

        //Visadores
        // $userVisator1 = User::find(13480977); // Siempre Visto Buenos María Soraya
        // $userVisator2 = User::find(13867504); //13.867.504 Alejandra Aguirre

        // $signer = Signer::query()
        //     ->where('type', 'signer')
        //     ->first();
        //$users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, today(), 'manager')->user_id;

        $signer = Authority::getAuthorityFromDate(44, today(), 'manager');
        //dd($signer);

        $visators = Signer::query()
            ->where('type', 'visator')
            ->get();

        DB::beginTransaction();

        try {
            $signature = new Signature();
            $signature->user_id = Auth::id();
            $signature->responsable_id = Auth::id();
            $signature->ou_id = auth()->user()->organizational_unit_id;
            $signature->request_date = now();
            $signature->type_id = Type::where('name', 'Carta')->first()->id;
            $signature->subject = 'Informe Idoneidad';
            $signature->description = "{$result->user->fullname} , Rut: {$result->user->id}-{$result->user->dv}, Establecimiento:{$result->psirequest->school->name} ";
            //            $signature->endorse_type = 'Visación opcional';
            $signature->endorse_type = 'Visación en cadena de responsabilidad';
            //            $signature->recipients = $userSigner->email . ',' . $userVisator1->email . ',' . $userVisator2->email;
            // $signature->distribution = $userSigner->email . ',' . $userVisator1->email . ',' . $userVisator2->email;

            $signature->distribution = $signer->user->email;
            foreach ($visators as $key => $visator) {
                $signature->distribution .= ',' . $visator->user->email;
            }

            $signature->visatorAsSignature = true;
            $signature->save();

            $signaturesFile = new SignaturesFile();
            //            $signaturesFile->file = base64_encode($pdf->output());
            $signaturesFile->md5_file = md5($pdf->output());
            $signaturesFile->file_type = 'documento';
            $signaturesFile->signature_id = $signature->id;
            $signaturesFile->save();

            //Se guarda en gcs
            $filePath = 'ionline/signatures/original/' . $signaturesFile->id . '.pdf';
            $signaturesFile->update(['file' => $filePath]);
            Storage::disk('gcs')->put($filePath, $pdf->output());

            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->signatures_file_id = $signaturesFile->id;
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->user_id = $signer->user->id;
            $signaturesFlow->ou_id = $signer->user->organizational_unit_id;
            $signaturesFlow->save();

            foreach ($visators as $key => $visator) {
                $signaturesFlow = new SignaturesFlow();
                $signaturesFlow->signatures_file_id = $signaturesFile->id;
                $signaturesFlow->type = 'visador';
                $signaturesFlow->user_id = $visator->user->id;
                $signaturesFlow->ou_id = $visator->user->organizational_unit_id;
                $signaturesFlow->sign_position = $key + 1;
                $signaturesFlow->save();
            }

            $result->signed_certificate_id = $signaturesFile->id;
            $result->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $signature->id;
    }

    public function signedSuitabilityCertificatePDF($id)
    {
        $result = Result::find($id);
        return Storage::disk('gcs')->response($result->signedCertificate->signed_file);
    }

    public function downloadManualUser()
    {
        $myFile = public_path("/manuales/idoneidad/Manual de Usuario Idoneidad Docente. Perfil Usuario.pdf");
        return response()->download($myFile);
    }

    public function downloadManualAdministrator()
    {
        $myFile = public_path("/manuales/idoneidad/Manual de Usuario Idoneidad Docente. Perfil Administrador.pdf");
        return response()->download($myFile);
    }

    public function configSignature()
    {
        $signers = Signer::all()->sortBy('sign_order');
        return view('suitability.config_signer', compact('signers'));
    }


    public function configSignatureAdd(Request $request)
    {
        $newSigner = new Signer($request->All());

        if ($newSigner->type === 'signer') {
            $signerQuantity = Signer::query()
                ->where('type', 'signer')
                ->count();

            if ($signerQuantity > 0) {
                session()->flash('warning', 'Ya existe un firmante.');
                return redirect()->back();
            }
        }

        $newSigner->save();

        return redirect()->route('suitability.configSignature');
    }

    public function configSignatureDelete(Signer $signer)
    {
        $signer->delete();

        return redirect()->route('suitability.configSignature');
    }

    public function update(PsiRequest $psirequest)
    {
        $psirequest->status = "Esperando Test";
        $psirequest->save();
        session()->flash('success', 'Se ha vuelto el test a estado "Esperando Test"');
        return redirect()->back();
    }

    public function slep(Request $request)
    {
        return $this->showSlepReport($request);
    }
    
    public function processSlepForm(Request $request)
    {
        return $this->showSlepReport($request);
    }
    
    private function showSlepReport(Request $request)
    {
        $currentYear = date('Y');
        $years = range(2021, $currentYear);
        $selectedYear = $request->input('year', $currentYear);
    
        $slepData = PsiRequest::with(['school', 'user'])->when($selectedYear, function ($query) use ($selectedYear) {
            return $query->whereYear('updated_at', $selectedYear);
        })
        ->whereIn('status', ['Aprobado', 'Rechazado'])
        ->orderBy('updated_at', 'asc')
        ->get();
    
        return view('suitability.report.slep', compact('years', 'selectedYear', 'slepData'));
    }
    


    


}
