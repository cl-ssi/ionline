<?php

namespace App\Http\Controllers\Allowances;

use App\Http\Controllers\Controller;
use App\Models\Allowances\AllowanceSign;
use App\Models\Allowances\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Rrhh\Authority;
use App\Notifications\Allowances\NewAllowance;
use App\Notifications\Allowances\EndAllowance;
use App\Notifications\Allowances\RejectedAllowance;
use Illuminate\Http\Response;
use App\Models\Documents\SignaturesFile;
use App\Services\SignatureService;

class AllowanceSignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function show(AllowanceSign $allowanceSign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function edit(AllowanceSign $allowanceSign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AllowanceSign $allowanceSign, $status, Allowance $allowance)
    {
        if($status == 'accepted'){
            foreach($allowance->allowanceSigns as $sign){
                $signatureTechnical = new SignatureService();
                dd($signatureTechnical);
            }
            $signs = $allowance->allowanceSigns;

            // ------------------ FIRMA ---------------------
            $signatureTechnical = new SignatureService();
            $signatureTechnical->addResponsible($this->store->visator);
            $signatureTechnical->addSignature(
                'Acta',
                "Acta de Recepción en Bodega #$control->id",
                "Recepción #$control->id",
                'Visación en cadena de responsabilidad',
                true
            );
            $signatureTechnical->addView('warehouse.pdf.report-reception', [
                'type' => '',
                'control' => $control,
                'store' => $control->store,
                'act_type' => 'reception'
            ]);
            $signatureTechnical->addVisators(collect([$this->store->visator]));
            $signatureTechnical->addSignatures(collect([]));
            $signatureTechnical = $signatureTechnical->sendRequest();
            $control->receptionSignature()->associate($signatureTechnical);
            $control->save();
            // -----------------------------------------------

            dd($signs);
            /*
            $AllowanceSignNotValid = false;

            //SI SOY AUTORIDAD EN LA PROXIMA FIRMA, SE CANCELA LA FIRMA ACTUAL
            $nextAllowanceSign = $allowanceSign->allowance->allowanceSigns->where('position', $allowanceSign->position + 1)->first();
            foreach(Authority::getAmIAuthorityFromOu(now(), 'manager', auth()->user()->id) as $authority){
                if($authority->organizational_unit_id == $nextAllowanceSign->organizational_unit_id){
                    dd('Autoridad Correlativa');

                    $allowanceSign->status = 'not valid';
                    $allowanceSign->save();
                    $AllowanceSignNotValid = true;

                    $nextAllowanceSign->user_id = Auth::user()->id;
                    $nextAllowanceSign->status = $status;
                    $nextAllowanceSign->date_sign = Carbon::now();
                    $nextAllowanceSign->save();

                    $position = $nextAllowanceSign->position + 1;
                }
            }

            //SI NO SE CANCELÓ LA PRIMERA FIRMA SE REALIZA EL PROCESO NORMALMENTE
            if($AllowanceSignNotValid != true){
                dd('Autoridad NO Correlativa');

                $allowanceSign->user_id = Auth::user()->id;
                $allowanceSign->status = $status;
                $allowanceSign->date_sign = Carbon::now();
                $allowanceSign->save();

                $position = $allowanceSign->position + 1;

                if($request->has('folio_sirh')){
                    $allowance->fill($request->All());
                    $allowance->save();
                }
            }

            $nextAllowanceSign = $allowanceSign->allowance->allowanceSigns->where('position', $position)->first();
            
            if($nextAllowanceSign->count() > 0){
                $nextAllowanceSign->status = 'pending';
                $nextAllowanceSign->save();

                //SE NOTIFICA PARA PROXIMO FIRMANTE 
                $notification = Authority::getAuthorityFromDate($nextAllowanceSign->organizational_unit_id, Carbon::now(), 'manager');
                $notification->user->notify(new NewAllowance($allowance));

                session()->flash('success', 'Estimado Usuario: Se aceptó viático con exito.');
                return redirect()->route('allowances.sign_index');
            }
            else{
                //SE NOTIFICA FIN DE PROCESO DE FIRMAS
                $allowance->userAllowance->notify(new EndAllowance($allowance));
                $allowance->userCreator->notify(new EndAllowance($allowance));

                session()->flash('success', 'Estimado Usuario: Su solicitud de viático ha sido Aceptada en su totalidad.');
                return redirect()->route('allowances.sign_index');
            }
            */

        }
        if($status == 'rejected'){
            $allowanceSign->user_id = Auth::user()->id;
            $allowanceSign->status = $status;
            $allowanceSign->observation = $request->observation;
            $allowanceSign->date_sign = Carbon::now();
            $allowanceSign->save();
    
            //SE NOTIFICA RECHAZO DE VIATICO
            $allowance->userCreator->notify(new RejectedAllowance($allowance));
            $allowance->userAllowance->notify(new RejectedAllowance($allowance));

            $allowance->status = 'rejected';
            $allowance->save();
    
            session()->flash('danger', 'Su solicitud de viático ha sido Rechazada con éxito.');
            return redirect()->route('allowances.sign_index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllowanceSign $allowanceSign)
    {
        //
    }

    public function create_form_document(Allowance $allowance){
        //dd($requestForm);

        // if($has_increased_expense){
        //     $requestForm->has_increased_expense = true;
        //     $requestForm->new_estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
        // }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('allowances.documents.form_document', compact('allowance'));

        return $pdf->stream('mi-archivo.pdf');

        // $formDocumentFile = PDF::loadView('request_form.documents.form_document', compact('requestForm'));
        // return $formDocumentFile->download('pdf_file.pdf');
    }

    public function create_view_document(Allowance $allowance){

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('allowances.documents.form_document', compact('allowance'));

        $output = $pdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="viatico_'.$allowance->id.'.pdf"']
        );
    }

    public function callbackSign($message, $modelId, SignaturesFile $signaturesFile = null){
        if (!$signaturesFile) {
            session()->flash('danger', $message);
            return redirect()->route('allowances.sign_index');
        }
        else{
            
            $allowance = Allowance::find($modelId);
            
            //SE ACTUALIZA EVENTO DE FINANZAS
            $allowance->AllowanceSigns->where('event_type', 'chief financial officer')->first()->update([
                'user_id'   => Auth::user()->id,
                'status'    => 'accepted',
                'date_sign' => now()
            ]);

            $allowanceSign = $allowance->AllowanceSigns->where('event_type', 'chief financial officer')->first();

            $allowanceSign->user_id = Auth::user()->id;
            $allowanceSign->status = 'accepted';
            $allowanceSign->date_sign = now();

            $allowanceSign->save();

            $allowance->signatures_file_id = $signaturesFile->id;
            $allowance->status = 'complete';
            $allowance->save();

            session()->flash('success', $message);
            return redirect()->route('allowances.sign_index');
        }
    }
}
