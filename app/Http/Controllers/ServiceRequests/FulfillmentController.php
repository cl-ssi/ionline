<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\FulfillmentItem;
use App\Models\ServiceRequests\ShiftControl;
use App\Models\Parameters\Profession;
use App\Models\Rrhh\OrganizationalUnit;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\User;
use Redirect;
use App\Models\Documents\Approval;
use App\Models\Documents\SignaturesFile;

use Illuminate\Support\Facades\Auth;
use App\Models\Rrhh\Authority;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FulfillmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $serviceRequests = null;

        $responsability_center_ou_id = $request->responsability_center_ou_id;
        $program_contract_type = $request->program_contract_type;
        // $estate = $request->estate;
        $profession_id = $request->profession_id;
        $name = $request->name;
        $id = $request->id;

        $authorities = Authority::getAmIAuthorityFromOu(now(),['manager','secretary','delegate'],$user->id);
        $array = array();
        foreach ($authorities as $key => $authority) {
          $array[] = $authority->organizational_unit_id;
        }

        $establishment_id = auth()->user()->organizationalUnit->establishment_id;
        // $establishment_id = $request->establishment_id;

        if (auth()->user()->can('Service Request: fulfillments responsable')) {
            $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user, $array){
                                                $subQuery->where('responsable_id',$user->id);
                                                // $subQuery->orwhere('user_id',$user->id);
                                                $subQuery->orWhereIn('ou_id',$array);
                                            })
                                            // ->orWhere('responsability_center_ou_id',$user->organizational_unit_id)
                                            ->when($responsability_center_ou_id != NULL, function ($q) use ($responsability_center_ou_id) {
                                                return $q->where('responsability_center_ou_id',$responsability_center_ou_id);
                                                })
                                            ->when($program_contract_type != NULL, function ($q) use ($program_contract_type) {
                                                    return $q->where('program_contract_type',$program_contract_type);
                                                })
                                            // ->when($estate != NULL, function ($q) use ($estate) {
                                            //       return $q->where('estate',$estate);
                                            //      })
                                            ->when($profession_id != NULL, function ($q) use ($profession_id) {
                                                return $q->where('profession_id', $profession_id);
                                            })
                                            ->when(($name != NULL), function ($q) use ($name) {
                                                    return $q->whereHas("employee", function($subQuery) use ($name){
                                                                $subQuery->where('name','LIKE','%'.$name.'%');
                                                                $subQuery->orwhere('fathers_family', 'LIKE', '%' . $name . '%');
                                                                $subQuery->orwhere('mothers_family', 'LIKE', '%' . $name . '%');
                                                            });
                                                    })
                                            ->when($id != NULL, function ($q) use ($id) {
                                                    return $q->where('id',$id);
                                                })
                                            // si es sst, se devuelve toda la info que no sea hetg ni hah.
                                            ->when($establishment_id == 38, function ($q) {
                                                return $q->whereNotIn('establishment_id', [1, 41]);
                                            })
                                            ->when($establishment_id != 38, function ($q) use ($establishment_id) {
                                                return $q->where('establishment_id',$establishment_id);
                                            })
                                            ->orderBy('id','desc')
                                            ->paginate(100);

        }
        // Service Request: fulfillments rrhh - Service Request: fulfillments finance
        else{
          $serviceRequests = ServiceRequest::when($responsability_center_ou_id != NULL, function ($q) use ($responsability_center_ou_id) {
                                                return $q->where('responsability_center_ou_id',$responsability_center_ou_id);
                                            })
                                          ->when($program_contract_type != NULL, function ($q) use ($program_contract_type) {
                                                 return $q->where('program_contract_type',$program_contract_type);
                                               })
                                           // ->when($estate != NULL, function ($q) use ($estate) {
                                           //       return $q->where('estate',$estate);
                                           //      })
                                           ->when($profession_id != NULL, function ($q) use ($profession_id) {
                                             return $q->where('profession_id', $profession_id);
                                           })
                                           ->when(($name != NULL), function ($q) use ($name) {
                                                   return $q->whereHas("employee", function($subQuery) use ($name){
                                                              $subQuery->where('name','LIKE','%'.$name.'%');
                                                              $subQuery->orwhere('fathers_family', 'LIKE', '%' . $name . '%');
                                                              $subQuery->orwhere('mothers_family', 'LIKE', '%' . $name . '%');
                                                         });
                                                })
                                          ->when($id != NULL, function ($q) use ($id) {
                                                return $q->where('id',$id);
                                               })
                                            // si es sst, se devuelve toda la info que no sea hetg ni hah.
                                            ->when($establishment_id == 38, function ($q) {
                                                return $q->whereNotIn('establishment_id', [1, 41]);
                                            })
                                            ->when($establishment_id != 38, function ($q) use ($establishment_id) {
                                                return $q->where('establishment_id',$establishment_id);
                                            })
                                           // ->where('program_contract_type','Mensual')
                                           ->orderBy('id','desc')
                                           ->paginate(100);
                                           // ->get();
        }


        if (auth()->user()->can('Service Request: fulfillments')) {
          foreach ($serviceRequests as $key => $serviceRequest) {
            //mensual -
            if ($serviceRequest->program_contract_type == "Mensual") {
              //only completed
              if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0 && $serviceRequest->SignatureFlows->whereNull('status')->count() == 0) {

              }else{
                $serviceRequests->forget($key);
              }
            }
            //"turno"
            else{

              //only completed
              if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0 && $serviceRequest->SignatureFlows->whereNull('status')->count() == 0) {

              }else{
                $serviceRequests->forget($key);
              }
            }

          }
        }

        $responsabilityCenters = OrganizationalUnit::where('establishment_id',$establishment_id)
                                                    ->orderBy('name')->get();
        $professions = Profession::orderBy('name', 'ASC')->get();

        return view('service_requests.requests.fulfillments.index',compact('serviceRequests','responsabilityCenters','request','professions'));
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
        $fulfillment = new Fulfillment($request->All());
        $fulfillment->save();

        session()->flash('success', 'Se ha registrado la información del período.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function edit_fulfillment(ServiceRequest $serviceRequest)
    {
        if($serviceRequest->SignatureFlows->isEmpty())
        {
            /* Envío al log de errores el id para su chequeo */
            logger("El ServiceRequest no tiene signature flows creados", ['id' => $serviceRequest->id]);
        }

        //se hizo esto para los casos en que no existan fulfillments
        if ($serviceRequest->fulfillments->count() == 0) {

            $start    = new DateTime($serviceRequest->start_date);
            $start->modify('first day of this month');
            $end      = new DateTime($serviceRequest->end_date);
            $end->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $periods   = new DatePeriod($start, $interval, $end);
            $cont_periods = iterator_count($periods);

            // crea de forma automática las cabeceras
            if ($serviceRequest->program_contract_type == "Mensual" || ($serviceRequest->program_contract_type == "Horas" && $serviceRequest->working_day_type == "HORA MÉDICA")) {
            if ($serviceRequest->fulfillments->count() == 0) {
                // if (!auth()->user()->can('Service Request: fulfillments responsable')) {
                //   session()->flash('danger', 'El usuario responsable no ha certificado el cumplimiento de la solicitud: <b>' . $serviceRequest->id . "</b>. No tiene acceso.");
                //   return redirect()->back();
                // }
                foreach ($periods as $key => $period) {
                $program_contract_type = "Mensual";
                $start_date_period = $period->format("d-m-Y");
                $end_date_period = Carbon::createFromFormat('d-m-Y', $period->format("d-m-Y"))->endOfMonth()->format("d-m-Y");
                if($key == 0){
                    $start_date_period = $serviceRequest->start_date->format("d-m-Y");
                }
                if (($cont_periods - 1) == $key) {
                    $end_date_period = $serviceRequest->end_date->format("d-m-Y");
                    $program_contract_type = "Parcial";
                }

                $fulfillment = new Fulfillment();
                $fulfillment->service_request_id = $serviceRequest->id;
                if ($serviceRequest->program_contract_type == "Mensual") {
                    $fulfillment->year = $period->format("Y");
                    $fulfillment->month = $period->format("m");
                }else{
                    $program_contract_type = "Horas Médicas";
                    $fulfillment->year = $period->format("Y");
                    $fulfillment->month = $period->format("m");
                }
                $fulfillment->type = $program_contract_type;
                $fulfillment->start_date = $start_date_period;
                $fulfillment->end_date = $end_date_period;
                $fulfillment->user_id = auth()->id();

                // $fulfillment->total_hours_to_pay = $serviceRequest->weekly_hours;
                // $fulfillment->total_to_pay = $serviceRequest->net_amount;

                $fulfillment->save();
                }

                // //crea detalle
                // foreach ($serviceRequest->shiftControls as $key => $shiftControl) {
                //
                //   //guarda
                //   $fulfillmentItem = new FulfillmentItem();
                //   $fulfillmentItem->fulfillment_id = $fulfillment->id;
                //   $fulfillmentItem->start_date = $shiftControl->start_date;
                //   $fulfillmentItem->end_date = $shiftControl->end_date;
                //   $fulfillmentItem->type = "Turno Médico";
                //   $fulfillmentItem->observation = $shiftControl->observation;
                //   $fulfillmentItem->user_id = auth()->id();
                //   $fulfillmentItem->save();
                //
                // }
            }
            }

            elseif($serviceRequest->program_contract_type == "Horas"){
                if ($serviceRequest->fulfillments->count() == 0) {
                    $fulfillment = new Fulfillment();
                    $fulfillment->service_request_id = $serviceRequest->id;
                    $fulfillment->type = "Horas No Médicas";
                    $fulfillment->year = $serviceRequest->start_date->format("Y");
                    $fulfillment->month = $serviceRequest->start_date->format("m");
                    $fulfillment->start_date = $serviceRequest->start_date;
                    $fulfillment->end_date = $serviceRequest->end_date;
                    // $fulfillment->observation = "Aprobaciones en flujo de firmas";
                    $fulfillment->user_id = auth()->id();
                    $fulfillment->save();
                }else {
                    $fulfillment = $serviceRequest->fulfillments->first();
                }

                // //crea detalle
                // foreach ($serviceRequest->shiftControls as $key => $shiftControl) {
                //   $fulfillmentItem = new FulfillmentItem();
                //   $fulfillmentItem->fulfillment_id = $fulfillment->id;
                //   $fulfillmentItem->start_date = $shiftControl->start_date;
                //   $fulfillmentItem->end_date = $shiftControl->end_date;
                //   $fulfillmentItem->type = "Turno";
                //   $fulfillmentItem->observation = $shiftControl->observation;
                //   $fulfillmentItem->user_id = auth()->id();
                //   $fulfillmentItem->save();
                // }
            }

            //tuve que hacer esto ya que no me devolvia fulfillments guardados.
            $serviceRequest = ServiceRequest::find($serviceRequest->id);

        }

        return view('service_requests.requests.fulfillments.edit',compact('serviceRequest'));
    }

    public function save_approbed_fulfillment(ServiceRequest $serviceRequest)
    {
        $start    = new DateTime($serviceRequest->start_date);
        $start->modify('first day of this month');
        $end      = new DateTime($serviceRequest->end_date);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $periods   = new DatePeriod($start, $interval, $end);
        $cont_periods = iterator_count($periods);

        // crea de forma automática las cabeceras
        if ($serviceRequest->fulfillments->count() == 0) {
          if (!auth()->user()->can('Service Request: fulfillments responsable')) {
            session()->flash('danger', 'El usuario responsable no ha certificado el cumplimiento de la solicitud: <b>' . $serviceRequest->id . "</b>. No tiene acceso.");
            return redirect()->back();
          }
          foreach ($periods as $key => $period) {
            $program_contract_type = "Mensual";
            $start_date_period = $period->format("d-m-Y");
            $end_date_period = Carbon::createFromFormat('d-m-Y', $period->format("d-m-Y"))->endOfMonth()->format("d-m-Y");
            if($key == 0){
              $start_date_period = $serviceRequest->start_date->format("d-m-Y");
            }
            if (($cont_periods - 1) == $key) {
              $end_date_period = $serviceRequest->end_date->format("d-m-Y");
              $program_contract_type = "Parcial";
            }

            $fulfillment = new Fulfillment();
            $fulfillment->service_request_id = $serviceRequest->id;
            if ($serviceRequest->program_contract_type == "Mensual") {
              $fulfillment->year = $period->format("Y");
              $fulfillment->month = $period->format("m");
            }else{
              $program_contract_type = "Turnos";
            }
            $fulfillment->type = $program_contract_type;

            $fulfillment->responsable_approbation = 1;
            $fulfillment->responsable_approbation_date = Carbon::now();
            $fulfillment->responsable_approver_id = auth()->id();

            $fulfillment->start_date = $start_date_period;
            $fulfillment->end_date = $end_date_period;
            $fulfillment->user_id = auth()->id();
            $fulfillment->save();
          }

          //crea detalle
          foreach ($serviceRequest->shiftControls as $key => $shiftControl) {

            //guarda
            $fulfillmentItem = new FulfillmentItem();
            $fulfillmentItem->fulfillment_id = $fulfillment->id;
            $fulfillmentItem->start_date = $shiftControl->start_date;
            $fulfillmentItem->end_date = $shiftControl->end_date;
            $fulfillmentItem->type = "Turno";

            $fulfillmentItem->responsable_approbation = 1;
            $fulfillmentItem->responsable_approbation_date = Carbon::now();
            $fulfillmentItem->responsable_approver_id = auth()->id();

            $fulfillmentItem->observation = $shiftControl->observation;
            $fulfillmentItem->user_id = auth()->id();
            $fulfillmentItem->save();

          }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fulfillment $fulfillment)
    {
        if($request->total_to_pay){

            // se agrega esta validación ya que existía un problema con la "coma" al reconocer un valor de miles o con separación de coma.
            $total_to_pay = str_replace(",", "", $request->total_to_pay);
            $total_to_pay = str_replace(".", ",", $total_to_pay);
            $request->merge([
                'total_to_pay' => $total_to_pay,
            ]);
            // 16/03/2023: Cuando se ingresa el total a pagar, se registra la fecha del movimiento.
            $fulfillment->total_to_pay_at = now();
        }

        $fulfillment->fill($request->all());

        if($request->hasFile('backup_assistance'))
        {

          //$file_name = $fulfillment->year.'_'.$fulfillment->month.'_'.$fulfillment->ServiceRequest->employee->name;
          $file_name = $fulfillment->year.'_'.$fulfillment->month.'_'.$fulfillment->id;
          $file = $request->file('backup_assistance');
          $fulfillment->backup_assistance = $file->storeAs('/ionline/service_request/backup_assistance', $file_name.'.'.$file->extension(), 'gcs');
          $fulfillment->save();


        }
        $fulfillment->save();

        session()->flash('success', 'Se ha modificado la información del período.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fulfillment $fulfillment)
    {
        // no se puede dejar un service request con cero periodos
        if($fulfillment->serviceRequest->fulfillments->count()==1){
            session()->flash("warning", "No se puede eliminar el período. Como mínimo debe existir un período de la solicitud.");
            return redirect()->back();
        }

        $fulfillment->delete();
        // session()->flash('success', 'Se ha eliminado el período.');

        // verificar de donde viene la llamada
        $url = url()->previous();
        if(str_contains($url,'profile')){

            // cuando el periodo es menor a 10
            if(str_contains(substr($url, -2),"/")){
                $url = substr($url, 0, -1);
            }
            // cuando periodo es mayor a 10
            else{
                $url = substr($url, 0, -2);
            }
            return Redirect::to($url);
        }

        return redirect()->back();
    }

    public function certificatePDF(Fulfillment $fulfillment, User $user = null)
    {
        // if($user) {
        //   $signer = $user;
        // }
        // else {
        //   $signer = $fulfillment->serviceRequest->SignatureFlows->where('sign_position',2)->first()->user;
        // }

        // validacion items
        if ($fulfillment->FulfillmentItems) {
          foreach ($fulfillment->FulfillmentItems as $key => $fulfillmentItem) {
            if ($fulfillmentItem->type == "Renuncia voluntaria") {
              if ($fulfillmentItem->end_date == null) {
                session()->flash('danger', 'La fecha de la renuncia involuntaria no está ingresada. Regularice esto antes de generar el certificado.');
                return redirect()->back();
              }
            }
          }
        }

        /* Siempre firma el que está logeado */
        $signer = auth()->user();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('service_requests.requests.fulfillments.report_certificate',compact('fulfillment','signer'));

        return $pdf->stream('mi-archivo.pdf');
    }

    /**
     * Función para generar archivo pdf con parámetro integer (no modelo)
     */
    public function certificatePDFSigned($fulfillment_id)
    {
        $fulfillment = Fulfillment::find($fulfillment_id);

        // validacion items
        if ($fulfillment->FulfillmentItems) {
          foreach ($fulfillment->FulfillmentItems as $key => $fulfillmentItem) {
            if ($fulfillmentItem->type == "Renuncia voluntaria") {
              if ($fulfillmentItem->end_date == null) {
                session()->flash('danger', 'La fecha de la renuncia involuntaria no está ingresada. Regularice esto antes de generar el certificado.');
                return redirect()->back();
              }
            }
          }
        }

        /* Siempre firma el que está logeado */
        $signer = auth()->user();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('service_requests.requests.fulfillments.report_certificate',compact('fulfillment','signer'));

        return $pdf->stream('mi-archivo.pdf');
    }

    /**
     * Función callback para solicitud de firma 
     */
    public function process($approval_id){
        $approval = Approval::find($approval_id);
        $fulfillment = $approval->approvable;

        /**
         * Creo un signature file, porque hay lógica que depende del signature file
         */
        if($approval->status==1){
            $signaturesFile = new SignaturesFile();
            $signaturesFile->signer_id = auth()->id();
            $signaturesFile->verification_code = str()->random(6);
            $signaturesFile->file = $approval->filename;
            $signaturesFile->signed_file = $approval->filename;
            $signaturesFile->save();
    
            $fulfillment->signatures_file_id = $signaturesFile->id;
            $fulfillment->save();
        }

        /**
         * Si se rechaza, no se guarda el status, porque
         * deben poder ingresar a aprobar/rechazar nuevamente.
         */
        if($approval->status==0){
            $approval->resetStatus();
        }
    }

    public function ApprovalActivation(Fulfillment $fulfillment){
        // crear una solicitud de aprobación
        $fulfillment->approval()->create([
            'module' => 'Honorarios',
            "module_icon" => "fas fa-rocket", 
            "subject" => "Nuevo cumplimiento para aprobación",
            "digital_signature" => false,
            "document_route_name" => "rrhh.service-request.fulfillment.certificate-pdf-signed", 
            "document_route_params" => json_encode(["fulfillment_id" => $fulfillment->id]),
            "sent_to_user_id" => auth()->id(),
            "callback_controller_method" => "App\Http\Controllers\ServiceRequests\FulfillmentController@process",
            "callback_controller_params" => json_encode(['fulfillment_id' => $fulfillment->id]),
            "filename" => "ionline/approvals/servicerequest/".$fulfillment->id.".pdf"
        ]);
    }

    public function confirmFulfillment(Fulfillment $fulfillment)
    {
        if (auth()->user()->can('Service Request: fulfillments responsable')) {

            if ($fulfillment->responsable_approver_id == NULL) {
                $fulfillment->responsable_approbation = 1;
                $fulfillment->responsable_approbation_date = Carbon::now();
                $fulfillment->responsable_approver_id = auth()->id();
                $fulfillment->save();

                //items
                foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
                    $FulfillmentItem->responsable_approbation = 1;
                    $FulfillmentItem->responsable_approbation_date = Carbon::now();
                    $FulfillmentItem->responsable_approver_id = auth()->id();
                    $FulfillmentItem->save();
                }
            }

        }

        if (auth()->user()->can('Service Request: fulfillments rrhh')) {
            if ($fulfillment->responsable_approver_id == NULL) {
                session()->flash('danger', 'No es posible aprobar, puesto que falta aprobación de Responsable.');
                return redirect()->back();
            }
            if ($fulfillment->total_hours_to_pay == NULL && $fulfillment->type != "Remanente") {
                session()->flash('danger', 'No es posible aprobar, puesto que falta ingresar total de horas a pagar.');
                return redirect()->back();
            }
            if ($fulfillment->total_to_pay == NULL) {
                session()->flash('danger', 'No es posible aprobar, puesto que falta ingresar total a pagar.');
                return redirect()->back();
            }
            if ($fulfillment->responsable_approver_id != NULL && $fulfillment->rrhh_approver_id == NULL) {
                $fulfillment->rrhh_approbation = 1;
                $fulfillment->rrhh_approbation_date = Carbon::now();
                $fulfillment->rrhh_approver_id = auth()->id();
                $fulfillment->save();

                //items
                foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
                $FulfillmentItem->rrhh_approbation = 1;
                $FulfillmentItem->rrhh_approbation_date = Carbon::now();
                $FulfillmentItem->rrhh_approver_id = auth()->id();
                $FulfillmentItem->save();
                }
            }
        }

        if (auth()->user()->can('Service Request: fulfillments finance')) {
            if ($fulfillment->rrhh_approver_id == NULL) {
                session()->flash('danger', 'No es posible aprobar, puesto que falta aprobación de RRHH');
                return redirect()->back();
            }
            if ($fulfillment->rrhh_approver_id != NULL && $fulfillment->finances_approver_id == NULL) {
                $fulfillment->finances_approbation = 1;
                $fulfillment->finances_approbation_date = Carbon::now();
                $fulfillment->finances_approver_id = auth()->id();
                $fulfillment->save();

                //items
                foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
                $FulfillmentItem->finances_approbation = 1;
                $FulfillmentItem->finances_approbation_date = Carbon::now();
                $FulfillmentItem->finances_approver_id = auth()->id();
                $FulfillmentItem->save();
                }
            }
        }

        session()->flash('success', 'Se ha confirmado la información del período.');
        return redirect()->back();
    }


    public function refuseFulfillment(Fulfillment $fulfillment)
    {
        if (auth()->user()->can('Service Request: fulfillments responsable')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            $fulfillment->responsable_approbation = 0;
            $fulfillment->responsable_approbation_date = Carbon::now();
            $fulfillment->responsable_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->responsable_approbation = 0;
              $FulfillmentItem->responsable_approbation_date = Carbon::now();
              $FulfillmentItem->responsable_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        if (auth()->user()->can('Service Request: fulfillments rrhh')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            session()->flash('danger', 'No es posible rechazar, puesto que falta aprobación de Responsable.');
            return redirect()->back();
          }
          if ($fulfillment->responsable_approver_id != NULL && $fulfillment->rrhh_approver_id == NULL) {
            $fulfillment->rrhh_approbation = 0;
            $fulfillment->rrhh_approbation_date = Carbon::now();
            $fulfillment->rrhh_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->rrhh_approbation = 0;
              $FulfillmentItem->rrhh_approbation_date = Carbon::now();
              $FulfillmentItem->rrhh_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        if (auth()->user()->can('Service Request: fulfillments finance')) {
          if ($fulfillment->rrhh_approver_id == NULL) {
            session()->flash('danger', 'No es posible rechazar, puesto que falta aprobación de RRHH');
            return redirect()->back();
          }
          if ($fulfillment->rrhh_approver_id != NULL && $fulfillment->finances_approver_id == NULL) {
            $fulfillment->finances_approbation = 0;
            $fulfillment->finances_approbation_date = Carbon::now();
            $fulfillment->finances_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->finances_approbation = 0;
              $FulfillmentItem->finances_approbation_date = Carbon::now();
              $FulfillmentItem->finances_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        session()->flash('success', 'Se ha rechazado la información del período.');
        return redirect()->back();
    }


    public function confirmFulfillmentBySignPosition(Fulfillment $fulfillment, $tipo = NULL)
    {
        // // dd($fulfillment);
        // if (auth()->user()->can('Service Request: fulfillments responsable')) {
        //   if ($fulfillment->responsable_approver_id == NULL) {
        //     $fulfillment->responsable_approbation = 1;
        //     $fulfillment->responsable_approbation_date = Carbon::now();
        //     $fulfillment->responsable_approver_id = auth()->id();
        //     $fulfillment->save();
        //
        //     //items
        //     foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
        //       $FulfillmentItem->responsable_approbation = 1;
        //       $FulfillmentItem->responsable_approbation_date = Carbon::now();
        //       $FulfillmentItem->responsable_approver_id = auth()->id();
        //       $FulfillmentItem->save();
        //     }
        //   }
        // }

        //RRHH
        if ($tipo == 4) {
          if ($fulfillment->responsable_approver_id == NULL) {
            session()->flash('danger', 'No es posible aprobar, puesto que falta aprobación de Responsable.');
            return redirect()->back();
          }
          if ($fulfillment->responsable_approver_id != NULL && $fulfillment->rrhh_approver_id == NULL) {
            $fulfillment->rrhh_approbation = $fulfillment->ServiceRequest->SignatureFlows->where('sign_position',$tipo)->first()->status;
            $fulfillment->rrhh_approbation_date = Carbon::now();
            $fulfillment->rrhh_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->rrhh_approbation = $fulfillment->ServiceRequest->SignatureFlows->where('sign_position',$tipo)->first()->status;
              $FulfillmentItem->rrhh_approbation_date = Carbon::now();
              $FulfillmentItem->rrhh_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        //finanzas
        if ($tipo == 5) {
          if ($fulfillment->rrhh_approver_id == NULL) {
            session()->flash('danger', 'No es posible aprobar, puesto que falta aprobación de RRHH');
            return redirect()->back();
          }
          if ($fulfillment->rrhh_approver_id != NULL && $fulfillment->finances_approver_id == NULL) {
            $fulfillment->finances_approbation = $fulfillment->ServiceRequest->SignatureFlows->where('sign_position',$tipo)->first()->status;
            $fulfillment->finances_approbation_date = Carbon::now();
            $fulfillment->finances_approver_id = auth()->id();
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->finances_approbation = $fulfillment->ServiceRequest->SignatureFlows->where('sign_position',$tipo)->first()->status;
              $FulfillmentItem->finances_approbation_date = Carbon::now();
              $FulfillmentItem->finances_approver_id = auth()->id();
              $FulfillmentItem->save();
            }
          }
        }

        session()->flash('success', 'Se ha confirmado la información del período.');
        return redirect()->back();
    }

    public function downloadInvoice(Fulfillment $fulfillment)
    {
      $storage_path = '/ionline/service_request/invoices/';
      $file =  $storage_path . $fulfillment->id . '.pdf';
      if (Storage::disk('gcs')->exists($file)) {
        return Storage::disk('gcs')->response($file, mb_convert_encoding($fulfillment->id.'.pdf', 'ASCII'));
      }else{
        session()->flash('warning', 'No se ha encontrado el archivo. Intente nuevamente en 10 minutos, si el problema persiste, suba nuevamente el archivo.');
        return redirect()->back();
      }

    }
    public function downloadResolution(ServiceRequest $serviceRequest)
    {
        $storage_path = '/ionline/service_request/resolutions/';
        $file =  $storage_path . $serviceRequest->id . '.pdf';
        if (Storage::disk('gcs')->exists($file)) {
          return Storage::disk('gcs')->response($file, mb_convert_encoding($serviceRequest->id.'.pdf', 'ASCII'));
        }else{
          session()->flash('warning', 'No se ha encontrado el archivo. Intente nuevamente en 10 minutos, si el problema persiste, suba nuevamente el archivo.');
          return redirect()->back();
        }
        /* Para google storage */
        //return Storage::disk('gcs')->response($file, mb_convert_encoding($serviceRequest->id.'.pdf', 'ASCII'));
    }
    // public function downloadAssistance(Fulfillment $fulfillment)
    // {
    //     $storage_path = '/ionline/service_request/backup_assistance/';
    //     $file =  $storage_path . $fulfillment->id . '.pdf';
    //     return Storage::disk('gcs')->response($file, mb_convert_encoding($fulfillment->id.'.pdf', 'ASCII'));
    // }

    public function signedCertificatePDF(Fulfillment $fulfillment)
    {
        try {
            return Storage::disk('gcs')->response($fulfillment->signedCertificate->signed_file);
        } catch (\Exception $e) {
            dd('No se pudo obtener el certificado firmado: ' .  $e);
        }
    }

    public function deletesignedCertificatePDF(Fulfillment $fulfillment)
    {
      //return Storage::disk('gcs')->delete($fulfillment->signedCertificate->signed_file);
      Storage::disk('gcs')->delete($fulfillment->signedCertificate->signed_file);
      $fulfillment->signatures_file_id = null;
      $fulfillment->save();

        if($fulfillment->approval){
            $fulfillment->approval->resetStatus();
        }

      session()->flash('success', 'Se ha borrado exitosamente el certificado de cumplimiento.');
      return redirect()->back();

    }


    public function deleteResponsableVB(Fulfillment $fulfillment)
    {
      $fulfillment->responsable_approbation = null;
      $fulfillment->responsable_approbation_date = null;
      $fulfillment->responsable_approver_id = null;

      $fulfillment->rrhh_approbation = null;
      $fulfillment->rrhh_approbation_date = null;
      $fulfillment->rrhh_approver_id = null;

      $fulfillment->finances_approbation = null;
      $fulfillment->finances_approbation_date = null;
      $fulfillment->finances_approver_id = null;

      $fulfillment->signatures_file_id = null;

      $fulfillment->save();
      session()->flash('success', 'Se ha borrado exitosamente el visto bueno de responsable.');
      return redirect()->back();

    }

    public function updatePaidValues(Request $request)
    {
        $fulfillment = Fulfillment::find($request->fulfillment_id);
        $fulfillment->update(['bill_number' => $request->bill_number,
            'total_hours_paid' => $request->total_hours_paid,
            'total_paid' => $request->total_paid,
            'payment_date' => $request->payment_date,
            'contable_month' => $request->contable_month]);

        return redirect()->back();
    }

  public function add_fulfillment(ServiceRequest $serviceRequest)
  {
    $new = $serviceRequest->fulfillments->last()->replicate([
        //se omiten
        'observation',
        'responsable_approbation',
        'responsable_approbation_date',
        'responsable_approver_id',
        'rrhh_approbation',
        'rrhh_approbation_date',
        'rrhh_approver_id',
        'finances_approbation',
        'finances_approbation_date',
        'finances_approver_id',
        'payment_ready',
        'payment_rejection_detail',
        'has_invoice_file',
        'signatures_file_id',
        'contable_month',
        'total_to_pay',
        'total_hours_to_pay',
        'total_paid',
        'total_hours_paid',
        'payment_date',
        'bill_number',
        'illness_leave',
        'leave_of_absence',
        'assistance',
        'backup_assistance'
    ]);
    $new->start_date = $new->start_date->addMonth()->toDateString();
    $new->end_date = $new->start_date->endOfMonth()->toDateString();
    $new->year = $new->start_date->format('Y');
    $new->month = $new->start_date->format('m');
    $new->save();
    session()->flash('success', 'Se ha creado nuevo período.');
    return redirect()->back();
  }
    
    public function add_remainder(Fulfillment $fulfillment){
        // Clona el post original
        $newFulfillment = $fulfillment->replicate();

        // Modifica las columnas necesarias
        $newFulfillment->type = 'Remanente';
        $newFulfillment->observation = 'Remanente por pagar';
        $newFulfillment->rrhh_approbation = null;
        $newFulfillment->rrhh_approbation_date = null;
        $newFulfillment->rrhh_approver_id = null;
        $newFulfillment->payment_ready = null;
        $newFulfillment->has_invoice_file = null;
        $newFulfillment->has_invoice_file_at = null;
        $newFulfillment->has_invoice_file_user_id = null;
        $newFulfillment->finances_approbation = null;
        $newFulfillment->finances_approbation_date = null;
        $newFulfillment->finances_approver_id = null;
        // $newFulfillment->invoice_path = null;
        // $newFulfillment->signatures_file_id = null;
        $newFulfillment->bill_number = null;
        $newFulfillment->total_hours_to_pay = null;
        $newFulfillment->total_to_pay = null;
        $newFulfillment->total_to_pay_at = null;
        $newFulfillment->total_hours_paid = null;
        $newFulfillment->total_paid = null;
        $newFulfillment->payment_date = null;
        $newFulfillment->contable_month = null;
        $newFulfillment->payment_rejection_detail = null;
        $newFulfillment->illness_leave = null;
        $newFulfillment->leave_of_absence = null;
        $newFulfillment->assistance = null;
        $newFulfillment->backup_assistance = null;

        // Guarda el nuevo post en la base de datos
        $newFulfillment->save();

        session()->flash('success', 'Se han creado campos para ingresar remanente.');
        return redirect()->back();
    }

}
