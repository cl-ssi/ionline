<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\FulfillmentItem;
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
    public function index()
    {
        $user_id = Auth::user()->id;
        $serviceRequests = null;

        if (Auth::user()->can('Service Request: fulfillments responsable')) {
          $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                               $subQuery->where('responsable_id',$user_id);
                                               $subQuery->orwhere('user_id',$user_id);
                                             })
                                           // ->where('program_contract_type','Mensual')
                                           ->orderBy('id','asc')
                                           ->get();
        }
        // Service Request: fulfillments rrhh - Service Request: fulfillments finance
        else{
          $serviceRequests = ServiceRequest::orderBy('id','asc')
                                           // ->where('program_contract_type','Mensual')
                                           ->get();
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
              // //se consideran los que tengan más de una visación
              // if ($serviceRequest->SignatureFlows->whereNotNull('status')->count() == 1) {
              //   $serviceRequests->forget($key);
              // }
              // // no se consideran rechazados
              // if ($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0) {
              //   $serviceRequests->forget($key);
              // }

              //only completed
              if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0 && $serviceRequest->SignatureFlows->whereNull('status')->count() == 0) {

              }else{
                $serviceRequests->forget($key);
              }
            }

          }
        }


        return view('service_requests.requests.fulfillments.index',compact('serviceRequests'));
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
        $start    = new DateTime($serviceRequest->start_date);
        $start->modify('first day of this month');
        $end      = new DateTime($serviceRequest->end_date);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $periods   = new DatePeriod($start, $interval, $end);
        $cont_periods = iterator_count($periods);

        // crea de forma automática las cabeceras
        if ($serviceRequest->program_contract_type == "Mensual") {
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
              $fulfillmentItem->observation = $shiftControl->observation;
              $fulfillmentItem->user_id = Auth::user()->id;
              $fulfillmentItem->save();

            }
          }
        }

        elseif($serviceRequest->program_contract_type == "Horas"){
          if ($serviceRequest->fulfillments->count() == 0) {
            $fulfillment = new Fulfillment();
            $fulfillment->service_request_id = $serviceRequest->id;
            $fulfillment->type = "Horas";
            $fulfillment->start_date = $serviceRequest->start_date;
            $fulfillment->end_date = $serviceRequest->end_date;
            $fulfillment->observation = "Aprobaciones en flujo de firmas";
            $fulfillment->user_id = Auth::user()->id;
            $fulfillment->save();
          }
        }


        return view('service_requests.requests.fulfillments.edit',compact('serviceRequest','periods'));
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

    public function certificatePDF(Fulfillment $fulfillment)
    {
        // dd($fulfillment);

        // $rut = explode("-", $ServiceRequest->rut);
        // $ServiceRequest->run_s_dv = number_format($rut[0],0, ",", ".");
        // $ServiceRequest->dv = $rut[1];
        //
        // $formatter = new NumeroALetras();
        // $ServiceRequest->gross_amount_description = $formatter->toWords($ServiceRequest->gross_amount, 0);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('service_requests.requests.fulfillments.report_certificate',compact('fulfillment'));

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

    public function downloadInvoice($fulfillmentId)
    {
        return Storage::response( 'invoices/' . $fulfillmentId . '.pdf', mb_convert_encoding($fulfillmentId . '.pdf', 'ASCII'));
    }


}
