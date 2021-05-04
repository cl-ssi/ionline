<?php

namespace App\Http\Controllers\Suitability;

use App\Http\Controllers\Controller;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Suitability\Result;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\User;
use App\Models\Suitability\PsiRequest;
use App\Models\Suitability\School;
use App\Models\UserExternal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SuitabilityController extends Controller
{
    //

    public function index(Request $request)
    {
        //return view('replacement_staff.index', compact('request'));
    }

    public function createExternal(School $school)
    {

        return view('external.suitability.create',compact('school'));
    }

    public function listOwn($school)
    {

        $psirequests = PsiRequest::where('school_id',$school)->get();
        return view('external.suitability.index',compact('psirequests'));


    }


    public function pending()
    {
        $psirequests = PsiRequest::where('status','Test Finalizado')->get();
        return view('suitability.pending', compact('psirequests'));
    }

    public function approved()
    {
        $psirequests = PsiRequest::where('status','Aprobado')->get();
        return view('suitability.approved', compact('psirequests'));
    }

    public function rejected()
    {
        $psirequests = PsiRequest::where('status','Rechazado')->get();
        return view('suitability.rejected', compact('psirequests'));
    }

    public function finalresult(PsiRequest $psirequest, $result)
    {

        $psirequest->status = $result;
        $psirequest->save();
        session()->flash('success', 'Se dio resultado de manera correcta');
        return redirect()->back();
    }





    public function indexOwn()
    {

        $psirequests = PsiRequest::all();
        return view('suitability.indexown', compact('psirequests'));

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
        return redirect()->route('suitability.create',$request->run);
    }



    public function create($run)
    {
        $user = User::firstOrNew(['id'=>$run]);
        return view('suitability.create',compact('run','user'));

    }
    public function storeSuitabilityExternal(Request $request)
    {
        $userexternal = new UserExternal($request->All());
        if(UserExternal::find(request('id')))
        {
            $userexternal->update();
        }
        else
        {
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
        session()->flash('success', 'Solicitud Creada Exitosamente, ahora el asistente puede ingresar a este mismo sitio con los datos de clave única a realizar la prueba');
        return redirect()->route('external');
    }

    public function store(Request $request)
    {
        $user = new User($request->All());
        $user->email_personal = $request->email;
        $user->external = 1;
        $user->givePermissionTo('Suitability: test');
        if(User::find(request('id')))
        {
        $user->update();
        }
        else
        {
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
        $userSigner = User::find(15685508);
        $userVisator1 = User::find(13480977);
        $userVisator2 = User::find(13867504);

//        $userSigner = User::find(16351236);
//        $userVisator1 = User::find(16351236);
//        $userVisator2 = User::find(16351236);

        DB::beginTransaction();

        try {
            $signature = new Signature();
            $signature->user_id = Auth::id();
            $signature->responsable_id = Auth::id();
            $signature->ou_id = Auth::user()->organizational_unit_id;
            $signature->request_date = now();
            $signature->document_type = 'Carta';
            $signature->subject = 'Informe Idoneidad';
            $signature->description = "{$result->user->fullname} , Rut: {$result->user->id}-{$result->user->dv} ";
//            $signature->endorse_type = 'Visación opcional';
            $signature->endorse_type = 'Visación en cadena de responsabilidad';
            $signature->recipients = $userSigner->email . ',' . $userVisator1->email . ',' . $userVisator2->email;
            $signature->distribution = $userSigner->full_name . ',' . $userVisator1->full_name . ',' . $userVisator2->full_name;
            $signature->visatorAsSignature = true;
            $signature->save();

            $signaturesFile = new SignaturesFile();
            $signaturesFile->file = base64_encode($pdf->output());
            $signaturesFile->md5_file = md5($pdf->output());
            $signaturesFile->file_type = 'documento';
            $signaturesFile->signature_id = $signature->id;
            $signaturesFile->save();

            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->signatures_file_id = $signaturesFile->id;
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->user_id = $userSigner->id;
            $signaturesFlow->ou_id = $userSigner->organizational_unit_id;
            $signaturesFlow->save();

            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->signatures_file_id = $signaturesFile->id;
            $signaturesFlow->type = 'visador';
            $signaturesFlow->user_id = $userVisator1->id;
            $signaturesFlow->ou_id = $userVisator1->organizational_unit_id;
            $signaturesFlow->sign_position = 1;
            $signaturesFlow->save();

            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->signatures_file_id = $signaturesFile->id;
            $signaturesFlow->type = 'visador';
            $signaturesFlow->user_id = $userVisator2->id;
            $signaturesFlow->ou_id = $userVisator2->organizational_unit_id;
            $signaturesFlow->sign_position = 2;
            $signaturesFlow->save();

            $result->signed_certificate_id = $signaturesFile->id;
            $result->save();

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        session()->flash('info', 'La solicitud de firma ' . $signature->id . ' ha sido creada. <a href="'. route('documents.signatures.index', ['mis_documentos']) . '"> Ver solicitudes </a>');
        return redirect()->back();
    }

    public function signedSuitabilityCertificatePDF($id)
    {
        $result = Result::find($id);
        header('Content-Type: application/pdf');
        if (isset($result->signedCertificate)) {
            echo base64_decode($result->signedCertificate->signed_file);
        }
    }

    public function downloadManualUser()
    {                
        $myFile = public_path("/manuales/idoneidad/Manual de Usuario Idoneidad Docente. Perfil Usuario.pdf");
        //$headers = ['Content-Type: application/pdf'];
    	return response()->download($myFile);
    }
}
