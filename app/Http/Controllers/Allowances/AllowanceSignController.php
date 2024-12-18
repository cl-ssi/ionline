<?php

namespace App\Http\Controllers\Allowances;

use App\Http\Controllers\Controller;
use App\Models\Allowances\AllowanceSign;
use App\Models\Allowances\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Rrhh\Authority;
use App\Notifications\Allowances\NewAllowance;
use App\Notifications\Allowances\EndAllowance;
use App\Notifications\Allowances\RejectedAllowance;
use Illuminate\Http\Response;
use App\Models\Documents\SignaturesFile;
use App\Services\SignatureService;
use App\Models\User;
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
            // CONSULTO SI EL FUNCIONARIO PERTENECE A HAH O SST (RAZON: CORRELATIVO)
            if($allowanceSign->allowance->userAllowance->organizationalUnit->establishment->id != Parameter::get('establishment', 'HospitalAltoHospicio') &&
                $allowanceSign->allowance->userAllowance->organizationalUnit->establishment->id != Parameter::get('establishment', 'SSTarapaca')){
                return redirect()->back()->with('warning', 'Estimado Usuario: El funcionario seleccionado no pertenece a Servicio de Salud Tarapacá o Hospital de Alto Hospicio (Favor contactar a su administrativo).');
            }
            else{
                //CONSULTO SI PRIMERA AUTORIDAD EXISTE
                if(Authority::getAuthorityFromDate($allowanceSign->allowance->userAllowance->organizational_unit_id, now(), 'manager')){
                    $allowanceSign->user_id = auth()->id();
                    $allowanceSign->status = $status;
                    $allowanceSign->date_sign = Carbon::now();
                    $allowanceSign->save();

                    // CONSULTO SI EXISTE PROXIMA APROBACIÓN (HAH: CONTABILIDAD)
                    if($allowanceSign->getNextSign()){
                        $nextSign           = $allowanceSign->getNextSign();
                        $nextSign->status   = 'pending';
                        $nextSign->save();
                    }
                    else{
                        $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit;
                        $subroDir = null;
                        //$funDir = null;
                        $dir = null;
                        
                        //PREGUNTO SI ES JEFE DE U.O.
                        if($allowanceSign->allowance->userAllowance->id == Authority::getAuthorityFromDate($allowanceSign->allowance->userAllowance->organizational_unit_id, now(), 'manager')->user_id){
                            // SI ES DE NIVEL 2 O SUPERIOR Y AUTORIDAD, SUBO UN NIVEL DE U.O.s
                            if($currentOu->level >= 2){
                                $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit->father;
                                if($currentOu->establishment_id == Parameter::get('establishment', 'SSTarapaca')){
                                    if($currentOu->level == 1){
                                        $dir = 'dir_sst';
                                    }
                                }
                                if($currentOu->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')){
                                    if($currentOu->level == 1){
                                        $dir = 'dir_hah';
                                    }
                                }
                            }
                            else{
                                $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit;

                                //SI ES PARA DIRECTOR DE ALTO HOSPICIO, SUBRROGANTE NULL Y ENVIO A DIRECCIÓN SST
                                if($currentOu->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')){
                                    $dir = 'dir_sst';
                                }
                                //SI ES PARA DIRECTOR DE SST, ENVÍO AL SUBRROGANTE SELECCIONADO
                                if($currentOu->establishment_id == Parameter::get('establishment', 'SSTarapaca')){
                                    if($allowanceSign->allowance->userAllowance->Subrogant){
                                        // $subroDir = $allowanceSign->allowance->userAllowance->Subrogant->id;
                                        // $subroDir = $request->approver;
                                        $dir = 'subro_sst';
                                    }
                                    else{
                                        return redirect()->route('allowances.show', $allowanceSign->allowance)->with('danger', 'Estimado usuario: No es posible aprobar viático, favor contactar a soporte para configurar subrrogancia de dirección');
                                    }
                                }
                            }
                            $alw_ou_level = $currentOu->level;
                        }
                        //NO AUTORIDAD
                        else{
                            $currentOu = $allowanceSign->allowance->userAllowance->organizationalUnit;
                            $alw_ou_level = $currentOu->level;
                            // SI ES FUNCIONARIO DE DIRECIÓN ALMACENO U.O.
                            if($alw_ou_level == 1){
                                if($currentOu->establishment_id == Parameter::get('establishment', 'SSTarapaca')){
                                    $dir = 'dir_sst';
                                }
                                if($currentOu->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')){
                                    $dir = 'dir_hah';
                                }
                            }
                        }

                        $lastApprovalId = null;
                        $count = 1;
                        $approval_dir = null;

                        if($alw_ou_level == 1){
                            $approval_dir = 1;
                            //APPROVALS CUANDO JEFATURA ES DIRECTOR O VIATICO DE DIRECCION
                            $approval = $allowanceSign->allowance->approvals()->create([
                                "module"                            => "Viáticos",
                                "module_icon"                       => "bi bi-wallet",
                                "subject"                           => 'Solicitud de Viático: ID '.$allowanceSign->allowance->correlative.'<br>
                                                                        Funcionario: '.$allowanceSign->allowance->userAllowance->fullName,
                                //"sent_to_ou_id"                     => ($subroDir == null) ? ($funDir == null) ? Parameter::get('ou','DireccionSSI') : $funDir : null,
                                "sent_to_ou_id"                     =>  ($dir == 'dir_sst') ? Parameter::get('ou','DireccionSSI') : (($dir == 'dir_hah') ? Parameter::get('ou', 'Direccion', $currentOu->establishment_id) : null),
                                "sent_to_user_id"                   => ($dir == 'subro_sst') ? $request->approver : null,
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
                                "position"                          => "right",
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
                                    "subject"                           => 'Solicitud de Viático: ID '.$allowanceSign->allowance->correlative.'<br>
                                                                            Funcionario: '.$allowanceSign->allowance->userAllowance->fullName,
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

                        $approval_dir_hah = null;
                        if($allowanceSign->allowance->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio') && $alw_ou_level >= 2){
                            // APPROVAL DE DIRECCIÓN DE ALTO HOSPICIO
                            $approval_dir_hah = 1;
                            $approval = $allowanceSign->allowance->approvals()->create([
                                "module"                            => "Viáticos",
                                "module_icon"                       => "bi bi-wallet",
                                "subject"                           => 'Solicitud de Viático: ID '.$allowanceSign->allowance->correlative.'<br>
                                                                        Funcionario: '.$allowanceSign->allowance->userAllowance->fullName,
                                "sent_to_ou_id"                     => Parameter::get('ou', 'Direccion', $allowanceSign->allowance->establishment_id),
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
                                    'process'       => null
                                ]),
                                "digital_signature"                 => true,
                                "position"                          => "right",
                                "start_y"                           => 82,
                                "filename"                          => "ionline/allowances/resol_pdf/".$allowanceSign->allowance->id."_".$count.".pdf"
                            ]);
                            $lastApproval = $approval;
                            $lastApprovalId = $approval->id;
                            $count++;
                        }

                        // APPROVAL DE FINANZAS
                        $approval = $allowanceSign->allowance->approvals()->create([
                            "module"                            => "Viáticos",
                            "module_icon"                       => "bi bi-wallet",
                            "subject"                           => 'Solicitud de Viático: ID '.$allowanceSign->allowance->correlative.'<br>
                                                                    Funcionario: '.$allowanceSign->allowance->userAllowance->fullName,
                            "sent_to_ou_id"                     => ($allowanceSign->allowance->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')) ? Parameter::get('ou','FinanzasHAH') : Parameter::get('ou','FinanzasSSI'),
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
                            "start_y"                           => ($approval_dir_hah != null || $approval_dir != null) ? 46 : 82,
                            "filename"                          => "ionline/allowances/resol_pdf/".$allowanceSign->allowance->id."_".$count.".pdf"
                        ]);
                    }
                }
                else{
                    return redirect()->route('allowances.show', $allowanceSign->allowance)->with('danger', 'Estimado usuario: No es posible aprobar viático, favor contactar a soporte para configurar autoridades');
                }
            }
            $approvedId = ($allowanceSign->allowance->correlative) ? $allowanceSign->allowance->correlative : $allowanceSign->allowance->id;
            session()->flash('success', 'Estimado usuario: Se ha aprobado correctamente el víatico ID: '.$approvedId);
            if($allowanceSign->event_type == "sirh"){
                return redirect()->route('allowances.sign_index');
            }
            if($allowanceSign->event_type == "contabilidad"){
                return redirect()->route('allowances.contabilidad_index');
            }
        }
        if($status == 'rejected'){
            $allowanceSign->user_id = auth()->id();
            $allowanceSign->status = $status;
            $allowanceSign->observation = $request->observation;
            $allowanceSign->date_sign = Carbon::now();
            $allowanceSign->save();
    
            //SE NOTIFICA RECHAZO DE VIATICO
            $allowanceSign->allowance->userCreator->notify(new RejectedAllowance($allowanceSign->allowance));
            $allowanceSign->allowance->userAllowance->notify(new RejectedAllowance($allowanceSign->allowance));

            $allowanceSign->allowance->status = 'rejected';
            $allowanceSign->allowance->save();
    
            session()->flash('danger', 'Su solicitud de viático ha sido Rechazada con éxito.');
            if($allowanceSign->event_type == "sirh"){
                return redirect()->route('allowances.sign_index');
            }
            if($allowanceSign->event_type == "contabilidad"){
                return redirect()->route('allowances.contabilidad_index');
            }
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
                'user_id'   => auth()->id(),
                'status'    => 'accepted',
                'date_sign' => now()
            ]);

            $allowanceSign = $allowance->AllowanceSigns->where('event_type', 'chief financial officer')->first();

            $allowanceSign->user_id = auth()->id();
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
