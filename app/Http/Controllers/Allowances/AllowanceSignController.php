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
use App\User;
use App\Models\Parameters\Parameter;

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
    public function update(Request $request, AllowanceSign $allowanceSign, $status)
    {
        if($status == 'accepted'){
            //CONSULTO SI PRIMERA AUTORIDAD EXISTE
            if(Authority::getAuthorityFromDate($allowanceSign->allowance->userAllowance->organizational_unit_id, now(), 'manager')){
                $allowanceSign->user_id = Auth::user()->id;
                $allowanceSign->status = $status;
                $allowanceSign->date_sign = Carbon::now();
                $allowanceSign->save();

                $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit;
                $subroDir = null;

                //PREGUNTO SI SOY EL JEFE DE MI U.O.
                if($allowanceSign->allowance->userAllowance->id == Authority::getAuthorityFromDate($allowanceSign->allowance->userAllowance->organizational_unit_id, now(), 'manager')->user_id){
                    // SI ES DE NIVEL 2 O SUPERIOR Y AUTORIDAD, SUBO UN NIVEL DE U.O.s
                    if($currentOu->level >= 2){
                        $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit->father;
                    }
                    else{
                        $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit;
                        if($allowanceSign->allowance->userAllowance->Subrogant){
                            $subroDir = $allowanceSign->allowance->userAllowance->Subrogant->id;
                        }
                        else{
                            return redirect()->route('allowances.show', $allowanceSign->allowance)->with('danger', 'Estimado usuario: No es posible aprobar viático, favor contactar a soporte para configurar subrrogancia de dirección');
                        }
                    }
                    $alw_ou_level = $currentOu->level;
                }
                else{
                    $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit;
                    $alw_ou_level = $currentOu->level;
                }

                $lastApprovalId = null;
                $count = 1;

                if($alw_ou_level == 1){
                    //APPROVALS CUANDO JEFATURA ES DIRECTOR O VIATICO DE DIRECCION
                    $approval = $allowanceSign->allowance->approvals()->create([
                        "module"                            => "Viáticos",
                        "module_icon"                       => "bi bi-wallet",
                        "subject"                           => 'Solicitud de Viático: ID '.$allowanceSign->allowance->id.'<br>
                                                                Funcionario: '.$allowanceSign->allowance->userAllowance->FullName,
                        "sent_to_ou_id"                     => ($subroDir == null) ? Parameter::get('ou','DireccionSSI') : null,
                        "sent_to_user_id"                   => ($subroDir != null) ? $subroDir : null,
                        "document_route_name"               => "allowances.show_resol_pdf",
                        "document_route_params"             => json_encode([
                            "allowance_id" => $allowanceSign->allowance->id
                        ]),
                        "document_pdf_path"                 => ($lastApprovalId == null) ? null : $lastApproval->filename,
                        "active"                            => true,
                        "previous_approval_id"              => $lastApprovalId,
                        "callback_controller_method"        => "App\Http\Controllers\Allowances\AllowanceController@approvalCallback",
                        "callback_controller_params"        => json_encode([
                            'allowance_id'  => $allowanceSign->allowance->id,
                            'process'       => null
                        ]),
                        "digital_signature"                 => true,
                        "position"                          => "center",
                        "start_y"                           => 82,
                        "filename"                          => "ionline/allowances/resol_pdf/".$allowanceSign->allowance->id."_".$count.".pdf"
                    ]);

                    $lastApprovalId = $approval->id;
                    $lastApproval = $approval;
                    $count++;
                }
                else{
                    //APPROVAL DE JEFATURAS DIRECTAS
                    for ($i = $alw_ou_level; $i >= 2; $i--){
                        //VALORES PARA UBICAR LA FIRMA EN
                        if($count == 1){
                            $start = 82;
                        }
                        if($count == 2){
                            $start = 46;
                        }
                        if($count == 3){
                            $start = 10;
                        }
                        if($count == 4){
                            $start = -26;
                        }
                        /* ******************************* */

                        $approval = $allowanceSign->allowance->approvals()->create([
                            "module"                            => "Viáticos",
                            "module_icon"                       => "bi bi-wallet",
                            "subject"                           => 'Solicitud de Viático: ID '.$allowanceSign->allowance->id.'<br>
                                                                    Funcionario: '.$allowanceSign->allowance->userAllowance->FullName,
                            "sent_to_ou_id"                     => $currentOu->id,
                            "document_route_name"               => "allowances.show_resol_pdf",
                            "document_route_params"             => json_encode([
                                "allowance_id" => $allowanceSign->allowance->id,
                            ]),
                            "document_pdf_path"                 => ($lastApprovalId == null) ? null : $lastApproval->filename,
                            "active"                            => ($lastApprovalId == null) ? true : false,
                            "previous_approval_id"              => $lastApprovalId,
                            "callback_controller_method"        => "App\Http\Controllers\Allowances\AllowanceController@approvalCallback",
                            "callback_controller_params"        => json_encode([
                                'allowance_id'  => $allowanceSign->allowance->id,
                                'process'       => null
                            ]),
                            "digital_signature"                 => true,
                            "position"                          => "center",
                            "start_y"                           => $start,
                            "filename"                          => "ionline/allowances/resol_pdf/".$allowanceSign->allowance->id."_".$count.".pdf"
                        ]);

                        $currentOu = $currentOu->father;
                        $lastApproval = $approval;
                        $lastApprovalId = $approval->id;
                        $count++;
                    }
                }

                // APPROVAL DE FINANZAS
                $approval = $allowanceSign->allowance->approvals()->create([
                    "module"                            => "Viáticos",
                    "module_icon"                       => "bi bi-wallet",
                    "subject"                           => 'Solicitud de Viático: ID '.$allowanceSign->allowance->id.'<br>
                                                            Funcionario: '.$allowanceSign->allowance->userAllowance->FullName,
                    "sent_to_ou_id"                     => Parameter::get('ou','FinanzasSSI'),
                    "document_route_name"               => "allowances.show_resol_pdf",
                    "document_route_params"             => json_encode([
                        "allowance_id" => $allowanceSign->allowance->id
                    ]),
                    "document_pdf_path"                 => ($lastApprovalId == null) ? null : $lastApproval->filename,
                    "active"                            => false,
                    "previous_approval_id"              => ($lastApprovalId == null) ? null : $lastApprovalId,
                    "callback_controller_method"        => "App\Http\Controllers\Allowances\AllowanceController@approvalCallback",
                    "callback_controller_params"        => json_encode([
                        'allowance_id'  => $allowanceSign->allowance->id,
                        'process'       => 'end'
                    ]),
                    "digital_signature"                 => true,
                    "position"                          => "right",
                    "start_y"                           => 82,
                    "filename"                          => "ionline/allowances/resol_pdf/".$allowanceSign->allowance->id."_".$count.".pdf"
                ]);
            }
            else{
                // session()->flash('success', 'Estimado usuario: Se ha aprobado correctamente el víatico ID: '.$allowanceSign->allowance->id);
                return redirect()->route('allowances.show', $allowanceSign->allowance)->with('danger', 'Estimado usuario: No es posible aprobar viático, favor contactar a soporte para configurar autoridades');
            }
            
            //ANTIGUO SISTEMA DE APROBACIONES
            /*
            //Se agrega folio SIRH
            $allowance->fill($request->All());
            $allowance->status = NULL;

            //VISADORES
            $visators = collect(new User);
            foreach($allowance->allowanceSigns->whereNotIn('event_type', array('sirh','chief financial officer')) as $sign){
                $currentAuthority = Authority::getAuthorityFromDate($sign->organizational_unit_id, now(), 'manager');
                $nextAllowanceSign = $allowance->allowanceSigns->where('position', $sign->position + 1)->first();
                $nextAuthority = Authority::getAuthorityFromDate($nextAllowanceSign->organizational_unit_id, now(), 'manager');
                
                if($currentAuthority->user_id != $nextAuthority->user_id){
                    $visators->push(Authority::getAuthorityFromDate($sign->organizational_unit_id, now(), 'manager')->user);
                }
            }   

            $ou_finance = Parameter::where('parameter', 'FinanzasSSI')->get();
            //TODO: se va caer si no encuentra la autoridad OJO
            $signature = Authority::getAuthorityFromDate($ou_finance->first()->value, now(), 'manager')->user;

            $signatureAllowance = new SignatureService();

            $signatureAllowance->addResponsible($allowance->userCreator);
            $signatureAllowance->addSignature(
                5,
                'Viático N°'. $allowance->id.' '.$allowance->userAllowance->TinnyName,
                'Viático N°'. $allowance->id.' '.$allowance->userAllowance->TinnyName,
                'Visación en cadena de responsabilidad',
                true
            );
            $signatureAllowance->addView('allowances.documents.allowance_document', [
                'allowance' => $allowance
            ]);

            $signatureAllowance->addVisators($visators);
            $signatureAllowance->addSignatures(collect([$signature]));

            $signatureAllowance = $signatureAllowance->sendRequest();

            $allowance->allowanceSignature()->associate($signatureAllowance);
            $allowance->save();
            */
            
            session()->flash('success', 'Estimado usuario: Se ha aprobado correctamente el víatico ID: '.$allowanceSign->allowance->id);
            return redirect()->route('allowances.sign_index');
            
            // $signs = $allowance->allowanceSigns;

            // ------------------ FIRMA ---------------------
            // $signatureTechnical = new SignatureService();
            // $signatureTechnical->addResponsible($this->store->visator);
            // $signatureTechnical->addSignature(
            //     'Acta',
            //     "Acta de Recepción en Bodega #$control->id",
            //     "Recepción #$control->id",
            //     'Visación en cadena de responsabilidad',
            //     true
            // );
            // $signatureTechnical->addView('warehouse.pdf.report-reception', [
            //     'type' => '',
            //     'control' => $control,
            //     'store' => $control->store,
            //     'act_type' => 'reception'
            // ]);
            // $signatureTechnical->addVisators(collect([$this->store->visator]));
            // $signatureTechnical->addSignatures(collect([]));
            // $signatureTechnical = $signatureTechnical->sendRequest();
            
            // $control->receptionSignature()->associate($signatureTechnical);
            // $control->save();
            // -----------------------------------------------

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
