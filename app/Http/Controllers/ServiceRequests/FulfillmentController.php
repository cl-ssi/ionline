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
use App\Rrhh\OrganizationalUnit;
use DateTime;
use DatePeriod;
use DateInterval;
use App\User;

use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
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
        $user = Auth::user();
        $serviceRequests = null;

        $responsability_center_ou_id = $request->responsability_center_ou_id;
        $program_contract_type = $request->program_contract_type;
        // $estate = $request->estate;
        $profession_id = $request->profession_id;
        $name = $request->name;
        $id = $request->id;

        $authorities = Authority::getAmIAuthorityFromOu(now(),['manager','secretary'],$user->id);
        $array = array();
        foreach ($authorities as $key => $authority) {
          $array[] = $authority->organizational_unit_id;
        }

        // $establishment_id = Auth::user()->organizationalUnit->establishment_id;
        $establishment_id = $request->establishment_id;

        if (Auth::user()->can('Service Request: fulfillments responsable')) {
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
                                           ->when($establishment_id != null && $establishment_id != 0, function ($q) use ($establishment_id) {
                                             return $q->where('establishment_id', $establishment_id);
                                           })
                                           ->when($establishment_id != null && $establishment_id == 0, function ($q) use ($establishment_id) {
                                             return $q->whereNotIn('establishment_id',[1,12]);
                                           })
                                           ->orderBy('id','asc')
                                           ->paginate(100);
                                           // ->get();
        }
        // Service Request: fulfillments rrhh - Service Request: fulfillments finance
        else{
          $serviceRequests = ServiceRequest::orderBy('id','asc')
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
                                           ->when($establishment_id != null && $establishment_id != 0, function ($q) use ($establishment_id) {
                                             return $q->where('establishment_id', $establishment_id);
                                           })
                                           ->when($establishment_id != null && $establishment_id == 0, function ($q) use ($establishment_id) {
                                             return $q->whereNotIn('establishment_id',[1,12]);
                                           })
                                           // ->where('program_contract_type','Mensual')
                                           ->paginate(100);
                                           // ->get();
        }


        if (Auth::user()->can('Service Request: fulfillments')) {
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

        $responsabilityCenters = OrganizationalUnit::orderBy('name', 'ASC')->get();
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
      // $fulfillment->responsable_approbation = 1;
      // $fulfillment->responsable_approver_id = Auth::user()->id;
      $fulfillment->save();

      // //turnos
      // if ($request->record != null) {
      //   foreach (ServiceRequest::find($request->service_request_id)->shiftControls as $key => $shiftControl) {
      //
      //     $flag = 0;
      //     foreach ($request->record as $key => $record) {
      //       $record = json_decode($record);
      //       if ($record->start_date == $shiftControl->start_date && $record->end_date == $shiftControl->end_date) {
      //         $flag = 1;
      //       }
      //     }
      //     //guarda
      //     $fulfillmentItem = new FulfillmentItem();
      //     $fulfillmentItem->fulfillment_id = $fulfillment->id;
      //     $fulfillmentItem->start_date = $shiftControl->start_date;
      //     $fulfillmentItem->end_date = $shiftControl->end_date;
      //     $fulfillmentItem->type = "Turno";
      //     $fulfillmentItem->responsable_approbation = $flag;
      //     $fulfillmentItem->responsable_approver_id = Auth::user()->id;
      //     $fulfillmentItem->observation = $shiftControl->observation;
      //     $fulfillmentItem->save();
      //
      //   }
      // }

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
            // if (!Auth::user()->can('Service Request: fulfillments responsable')) {
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
              $fulfillment->user_id = Auth::user()->id;

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
            //   $fulfillmentItem->user_id = Auth::user()->id;
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
            $fulfillment->user_id = Auth::user()->id;
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
          //   $fulfillmentItem->user_id = Auth::user()->id;
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
          if (!Auth::user()->can('Service Request: fulfillments responsable')) {
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
            $fulfillment->responsable_approver_id = Auth::user()->id;

            $fulfillment->start_date = $start_date_period;
            $fulfillment->end_date = $end_date_period;
            $fulfillment->user_id = Auth::user()->id;
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
            $fulfillmentItem->responsable_approver_id = Auth::user()->id;

            $fulfillmentItem->observation = $shiftControl->observation;
            $fulfillmentItem->user_id = Auth::user()->id;
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
    public function destroy($id)
    {
        //
    }

    public function certificatePDF(Fulfillment $fulfillment, User $user = null)
    {
        // if($user) {
        //   $signer = $user;
        // }
        // else {
        //   $signer = $fulfillment->serviceRequest->SignatureFlows->where('sign_position',2)->first()->user;
        // }

        /* Siempre firma el que está logeado */
        $signer = auth()->user();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('service_requests.requests.fulfillments.report_certificate',compact('fulfillment','signer'));

        return $pdf->stream('mi-archivo.pdf');
    }

    public function confirmFulfillment(Fulfillment $fulfillment)
    {
//        if ($request->hasFile('invoice')){
//            $invoiceFile = $request->file('invoice');
//        };
//
//        Storage::disk('local')->put("invoices/$fulfillment->id.pdf", $invoiceFile);
//        $fulfillment->invoice_path = '';

        // dd($fulfillment);
        if (Auth::user()->can('Service Request: fulfillments responsable')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            $fulfillment->responsable_approbation = 1;
            $fulfillment->responsable_approbation_date = Carbon::now();
            $fulfillment->responsable_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->responsable_approbation = 1;
              $FulfillmentItem->responsable_approbation_date = Carbon::now();
              $FulfillmentItem->responsable_approver_id = Auth::user()->id;
              $FulfillmentItem->save();
            }
          }
        }

        if (Auth::user()->can('Service Request: fulfillments rrhh')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            session()->flash('danger', 'No es posible aprobar, puesto que falta aprobación de Responsable.');
            return redirect()->back();
          }
          if ($fulfillment->responsable_approver_id != NULL && $fulfillment->rrhh_approver_id == NULL) {
            $fulfillment->rrhh_approbation = 1;
            $fulfillment->rrhh_approbation_date = Carbon::now();
            $fulfillment->rrhh_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->rrhh_approbation = 1;
              $FulfillmentItem->rrhh_approbation_date = Carbon::now();
              $FulfillmentItem->rrhh_approver_id = Auth::user()->id;
              $FulfillmentItem->save();
            }
          }
        }

        if (Auth::user()->can('Service Request: fulfillments finance')) {
          if ($fulfillment->rrhh_approver_id == NULL) {
            session()->flash('danger', 'No es posible aprobar, puesto que falta aprobación de RRHH');
            return redirect()->back();
          }
          if ($fulfillment->rrhh_approver_id != NULL && $fulfillment->finances_approver_id == NULL) {
            $fulfillment->finances_approbation = 1;
            $fulfillment->finances_approbation_date = Carbon::now();
            $fulfillment->finances_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->finances_approbation = 1;
              $FulfillmentItem->finances_approbation_date = Carbon::now();
              $FulfillmentItem->finances_approver_id = Auth::user()->id;
              $FulfillmentItem->save();
            }
          }
        }

        session()->flash('success', 'Se ha confirmado la información del período.');
        return redirect()->back();
    }


    public function refuseFulfillment(Fulfillment $fulfillment)
    {
        if (Auth::user()->can('Service Request: fulfillments responsable')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            $fulfillment->responsable_approbation = 0;
            $fulfillment->responsable_approbation_date = Carbon::now();
            $fulfillment->responsable_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->responsable_approbation = 0;
              $FulfillmentItem->responsable_approbation_date = Carbon::now();
              $FulfillmentItem->responsable_approver_id = Auth::user()->id;
              $FulfillmentItem->save();
            }
          }
        }

        if (Auth::user()->can('Service Request: fulfillments rrhh')) {
          if ($fulfillment->responsable_approver_id == NULL) {
            session()->flash('danger', 'No es posible rechazar, puesto que falta aprobación de Responsable.');
            return redirect()->back();
          }
          if ($fulfillment->responsable_approver_id != NULL && $fulfillment->rrhh_approver_id == NULL) {
            $fulfillment->rrhh_approbation = 0;
            $fulfillment->rrhh_approbation_date = Carbon::now();
            $fulfillment->rrhh_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->rrhh_approbation = 0;
              $FulfillmentItem->rrhh_approbation_date = Carbon::now();
              $FulfillmentItem->rrhh_approver_id = Auth::user()->id;
              $FulfillmentItem->save();
            }
          }
        }

        if (Auth::user()->can('Service Request: fulfillments finance')) {
          if ($fulfillment->rrhh_approver_id == NULL) {
            session()->flash('danger', 'No es posible rechazar, puesto que falta aprobación de RRHH');
            return redirect()->back();
          }
          if ($fulfillment->rrhh_approver_id != NULL && $fulfillment->finances_approver_id == NULL) {
            $fulfillment->finances_approbation = 0;
            $fulfillment->finances_approbation_date = Carbon::now();
            $fulfillment->finances_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->finances_approbation = 0;
              $FulfillmentItem->finances_approbation_date = Carbon::now();
              $FulfillmentItem->finances_approver_id = Auth::user()->id;
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
        // if (Auth::user()->can('Service Request: fulfillments responsable')) {
        //   if ($fulfillment->responsable_approver_id == NULL) {
        //     $fulfillment->responsable_approbation = 1;
        //     $fulfillment->responsable_approbation_date = Carbon::now();
        //     $fulfillment->responsable_approver_id = Auth::user()->id;
        //     $fulfillment->save();
        //
        //     //items
        //     foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
        //       $FulfillmentItem->responsable_approbation = 1;
        //       $FulfillmentItem->responsable_approbation_date = Carbon::now();
        //       $FulfillmentItem->responsable_approver_id = Auth::user()->id;
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
            $fulfillment->rrhh_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->rrhh_approbation = $fulfillment->ServiceRequest->SignatureFlows->where('sign_position',$tipo)->first()->status;
              $FulfillmentItem->rrhh_approbation_date = Carbon::now();
              $FulfillmentItem->rrhh_approver_id = Auth::user()->id;
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
            $fulfillment->finances_approver_id = Auth::user()->id;
            $fulfillment->save();

            //items
            foreach ($fulfillment->FulfillmentItems as $key => $FulfillmentItem) {
              $FulfillmentItem->finances_approbation = $fulfillment->ServiceRequest->SignatureFlows->where('sign_position',$tipo)->first()->status;
              $FulfillmentItem->finances_approbation_date = Carbon::now();
              $FulfillmentItem->finances_approver_id = Auth::user()->id;
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
        return Storage::disk('gcs')->response($file, mb_convert_encoding($fulfillment->id.'.pdf', 'ASCII'));
    }
    public function downloadResolution(ServiceRequest $serviceRequest)
    {
        $storage_path = '/ionline/service_request/resolutions/';
        $file =  $storage_path . $serviceRequest->id . '.pdf';
        return Storage::disk('gcs')->response($file, mb_convert_encoding($serviceRequest->id.'.pdf', 'ASCII'));
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
        return Storage::disk('gcs')->response($fulfillment->signedCertificate->signed_file);
//        header('Content-Type: application/pdf');
//        if (isset($fulfillment->signedCertificate)) {
//            echo base64_decode($fulfillment->signedCertificate->signed_file);
//        }
    }

    public function deletesignedCertificatePDF(Fulfillment $fulfillment)
    {
      //return Storage::disk('gcs')->delete($fulfillment->signedCertificate->signed_file);
      Storage::disk('gcs')->delete($fulfillment->signedCertificate->signed_file);
      $fulfillment->signatures_file_id = null;
      $fulfillment->save();
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

}
