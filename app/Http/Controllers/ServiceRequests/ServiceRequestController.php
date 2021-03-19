<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Subdirection;
use App\Models\ServiceRequests\ResponsabilityCenter;
use App\Models\ServiceRequests\SignatureFlow;
use App\Models\ServiceRequests\ShiftControl;
use Luecano\NumeroALetras\NumeroALetras;
use App\Mail\ServiceRequestNotification;
use App\Mail\DerivationNotification;
use Illuminate\Support\Facades\Mail;
use App\Rrhh\OrganizationalUnit;
use App\Establishment;
use App\User;

use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;

class ServiceRequestController extends Controller

{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $user_id = Auth::user()->id;
      $users = User::orderBy('name','ASC')->get();

      $serviceRequestsOthersPendings = [];
      $serviceRequestsMyPendings = [];
      $serviceRequestsAnswered = [];
      $serviceRequestsCreated = [];
      $serviceRequestsRejected = [];

      $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                           $subQuery->where('responsable_id',$user_id);
                                           $subQuery->orwhere('user_id',$user_id);
                                         })
                                         ->orderBy('id','asc')
                                         ->get();

      foreach ($serviceRequests as $key => $serviceRequest) {
        //not rejected
        if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0) {
          foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
            //with responsable_id
            if ($user_id == $signatureFlow->responsable_id) {
              if ($signatureFlow->status == NULL) {
                if ($serviceRequest->SignatureFlows->where('sign_position',$signatureFlow->sign_position-1)->first()->status == NULL) {
                  $serviceRequestsOthersPendings[$serviceRequest->id] = $serviceRequest;
                }else{
                  $serviceRequestsMyPendings[$serviceRequest->id] = $serviceRequest;
                }
              }else{
                $serviceRequestsAnswered[$serviceRequest->id] = $serviceRequest;
              }
            }
            //with organizational unit authority
            if ($user_id == $signatureFlow->ou_id) {

            }
          }
        }
        else{
          $serviceRequestsRejected[$serviceRequest->id] = $serviceRequest;
        }
      }


      foreach ($serviceRequests as $key => $serviceRequest) {
        if (!array_key_exists($serviceRequest->id,$serviceRequestsOthersPendings)) {
          if (!array_key_exists($serviceRequest->id,$serviceRequestsMyPendings)) {
            if (!array_key_exists($serviceRequest->id,$serviceRequestsAnswered)) {
              $serviceRequestsCreated[$serviceRequest->id] = $serviceRequest;
            }
          }
        }
      }

      return view('service_requests.requests.index', compact('serviceRequestsMyPendings','serviceRequestsOthersPendings','serviceRequestsRejected','serviceRequestsAnswered','serviceRequestsCreated','users'));
  }

  public function aditional_data_list(Request $request){

    // dd($request);
    $responsability_center_ou_id = $request->responsability_center_ou_id;
    // dd($responsability_center_ou_id);
    $serviceRequests = ServiceRequest::
                                       when($responsability_center_ou_id != NULL, function ($q) use ($responsability_center_ou_id) {
                                          return $q->where('responsability_center_ou_id',$responsability_center_ou_id);
                                       })
                                     ->orderBy('id','asc')->get();
    $responsabilityCenters = OrganizationalUnit::where('establishment_id',1)->orderBy('name', 'ASC')->get();
    return view('service_requests.requests.aditional_data_list', compact('serviceRequests','responsabilityCenters'));
  }

  public function transfer_requests(Request $request){

    $users = User::orderBy('name','ASC')->get();
    // dd(User::find(14101085)->serviceRequestsOthersPendingsCount());
    $responsability_center_ou_id = $request->responsability_center_ou_id;
    // dd($responsability_center_ou_id);
    $serviceRequests = ServiceRequest::
                                       when($responsability_center_ou_id != NULL, function ($q) use ($responsability_center_ou_id) {
                                          return $q->where('responsability_center_ou_id',$responsability_center_ou_id);
                                       })
                                     ->orderBy('id','asc')->get();
    $responsabilityCenters = OrganizationalUnit::where('establishment_id',1)->orderBy('name', 'ASC')->get();
    return view('service_requests.requests.transfer_requests', compact('serviceRequests','responsabilityCenters','users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $users = User::orderBy('name','ASC')->get();
    $establishments = Establishment::orderBy('name', 'ASC')->get();

     //signature flow
     // dd(Auth::user()->organizationalUnit->establishment_id);
     $signatureFlows = [];
     if (Auth::user()->organizationalUnit->establishment_id == 38) {

       $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',38)->orderBy('name', 'ASC')->get();
       $responsabilityCenters = OrganizationalUnit::where('establishment_id',38)->orderBy('name', 'ASC')->get();

       //Hector Reyno (CGU)
       if (Auth::user()->organizationalUnit->id == 24) {
         // // 24 - Consultorio General Urbano Dr. Hector Reyno
         // if(Authority::getAuthorityFromDate(24,Carbon::now(),'manager')==null) {$user=14745638;}
         // else{$user=Authority::getAuthorityFromDate(24,Carbon::now(),'manager')->user->id;}
         // $signatureFlows['Directora CGU'] = $user;
         // // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
         // if(Authority::getAuthorityFromDate(2,Carbon::now(),'manager')==null) {$user=14104369;}
         // else{$user=Authority::getAuthorityFromDate(2,Carbon::now(),'manager')->user->id;}
         // $signatureFlows['S.D.G.A SSI'] = $user;
         // // 59 - Planificación y Control de Gestión de Recursos Humanos
         // if(Authority::getAuthorityFromDate(59,Carbon::now(),'manager')==null) {$user=14112543;}
         // else{$user=Authority::getAuthorityFromDate(59,Carbon::now(),'manager')->user->id;}
         // $signatureFlows['Planificación CG RRHH'] = $user;
         // // 44 - Subdirección de Gestión y Desarrollo de las Personas
         // if(Authority::getAuthorityFromDate(44,Carbon::now(),'manager')==null) {$user=15685508;}
         // else{$user=Authority::getAuthorityFromDate(44,Carbon::now(),'manager')->user->id;}
         // $signatureFlows['S.G.D.P SSI'] = $user;
         // // 31 - Subdirección de Recursos Físicos y Financieros
         // if(Authority::getAuthorityFromDate(31,Carbon::now(),'manager')==null) {$user=11612834;}
         // else{$user=Authority::getAuthorityFromDate(31,Carbon::now(),'manager')->user->id;}
         // $signatureFlows['S.D.A SSI'] = $user;
         // // 1 - Dirección
         // if(Authority::getAuthorityFromDate(1,Carbon::now(),'manager')==null) {$user=9381231;}
         // else{$user=Authority::getAuthorityFromDate(1,Carbon::now(),'manager')->user->id;}
         // $signatureFlows['Director SSI'] = $user;
         $signatureFlows['RRHH CGU'] = 10739552; //RR.HH del CGU
         $signatureFlows['Directora CGU'] = 14745638; // 24 - Consultorio General Urbano Dr. Hector Reyno
         $signatureFlows['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
         $signatureFlows['Planificación CG RRHH'] = 14112543; // 59 - Planificación y Control de Gestión de Recursos Humanos
         $signatureFlows['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
         $signatureFlows['S.D.A SSI'] = 11612834; // 31 - Subdirección de Recursos Físicos y Financieros
         $signatureFlows['Director SSI'] = 9381231; // 1 - Dirección
       }
       //servicio de salud iqq
       else{
         $signatureFlows['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
         $signatureFlows['Planificación CG RRHH'] = 14112543; // 59 - Planificación y Control de Gestión de Recursos Humanos
         $signatureFlows['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
         $signatureFlows['S.D.A SSI'] = 11612834; // 31 - Subdirección de Recursos Físicos y Financieros
         $signatureFlows['Director SSI'] = 9381231; // 1 - Dirección
       }
     }
     //hospital
     elseif(Auth::user()->organizationalUnit->establishment_id == 1){
       $signatureFlows['Subdirector'] = 9882506; // 88 - Subdirección Médica
       $signatureFlows['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
       $signatureFlows['S.G.D.P Hospital'] = 16390845; // 86 - Subdirección de Gestión de Desarrollo de las Personas
       $signatureFlows['Jefe Finanzas'] = 13866194; // 11 - Departamento de Finanzas
       $signatureFlows['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
       $signatureFlows['Director Hospital'] = 14101085; // 84 - Dirección

       $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
       $responsabilityCenters = OrganizationalUnit::where('establishment_id',1)
                                                  // ->where('name','LIKE','%unidad%')
                                                  // ->orwhere('name','LIKE','%servicio%')
                                                  // ->orwhere('name','LIKE','%estadio%')
                                                  // ->orwhere('name','LIKE','%covid%')
                                                  ->orderBy('name', 'ASC')->get();
     }
    //another
     else{
       session()->flash('info', 'Usted no posee una unidad organizacional válida para ingresar hojas de ruta.');
       return redirect()->back();
     }



     //array para solicitud por turnos
     $signatureFlowsTurnos = [];
     $sumaAlzadaFlow = [];
     if (Auth::user()->organizationalUnit->establishment_id == 38) {
       //Hector Reyno (CGU)
       if (Auth::user()->organizationalUnit->id == 24) {
         $signatureFlows['RRHH CGU'] = 10739552; //RR.HH del CGU
         $signatureFlowsTurnos['Directora CGU'] = 14745638; // 24 - Consultorio General Urbano Dr. Hector Reyno
         // $signatureFlowsTurnos['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
         // $signatureFlowsTurnos['Planificación CG RRHH'] = 14112543; // 59 - Planificación y Control de Gestión de Recursos Humanos
         $signatureFlowsTurnos['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
         $signatureFlowsTurnos['S.D.A SSI'] = 11612834; // 31 - Subdirección de Recursos Físicos y Financieros
         // $signatureFlowsTurnos['Director SSI'] = 9381231; // 1 - Dirección
       }
       //servicio de salud iqq
       else{
         // $signatureFlowsTurnos['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
         $signatureFlowsTurnos['Planificación CG RRHH'] = 14112543; // 59 - Planificación y Control de Gestión de Recursos Humanos
         $signatureFlowsTurnos['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
         $signatureFlowsTurnos['S.D.A SSI'] = 11612834; // 31 - Subdirección de Recursos Físicos y Financieros
         // $signatureFlowsTurnos['Director SSI'] = 9381231; // 1 - Dirección
       }
     }
     //hospital
     elseif(Auth::user()->organizationalUnit->establishment_id == 1){
       $signatureFlowsTurnos['Subdirector'] = 9882506; // 88 - Subdirección Médica
       // $signatureFlowsTurnos['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
       $signatureFlowsTurnos['S.G.D.P Hospital'] = 16390845; // 86 - Subdirección de Gestión de Desarrollo de las Personas
       $signatureFlowsTurnos['Jefe Finanzas'] = 13866194; // 11 - Departamento de Finanzas
       // $signatureFlowsTurnos['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
       // $signatureFlowsTurnos['Director Hospital'] = 14101085; // 84 - Dirección
     }

     $sumaAlzadaFlow['S.G.D.P Hospital'] = 16390845;
     $sumaAlzadaFlow['Jefe Finanzas'] = 13866194;
     $sumaAlzadaFlow['Director Hospital'] = 14101085;

     // dd($signatureFlowsTurnos);

    return view('service_requests.requests.create', compact('subdirections','responsabilityCenters','users','establishments','signatureFlows','signatureFlowsTurnos','sumaAlzadaFlow'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //dd($request->users);
      //validation existence
      $serviceRequest = ServiceRequest::where('rut',$request->run."-".$request->dv)
                                      ->where('program_contract_type',$request->program_contract_type)
                                      ->where('start_date',$request->start_date)
                                      ->where('end_date',$request->end_date)->get();
      if ($serviceRequest->count() > 0) {
        session()->flash('info', 'Ya existe una solicitud ingresada para este funcionario (Solicitud nro <b>'.$serviceRequest->first()->id.'</b> )');
        return redirect()->back();
      }


      //validate, user has ou
      if($request->users <> null){
        foreach ($request->users as $key => $user) {
          // dd(User::find($user)->id);
          $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', User::find($user)->id);
          $employee = User::find($user)->position;
          if ($authorities!=null) {
            $employee = $authorities[0]->position;
            $ou_id = $authorities[0]->organizational_unit_id;
          }else{
            $ou_id = User::find($user)->organizational_unit_id;
          }

          // dd($ou_id);

          if ($ou_id == null) {
            session()->flash('info', User::find($user)->getFullNameAttribute().' no posee unidad organizacional asignada.');
            return redirect()->back();
          }
        }
      }

      // dd($request->users);
      $serviceRequest = new ServiceRequest($request->All());
      $serviceRequest->rut = $request->run ."-". $request->dv;
      $serviceRequest->user_id = Auth::id();
      $serviceRequest->save();

      //guarda control de turnos
      if ($request->shift_start_date!=null) {
        foreach ($request->shift_start_date as $key => $shift_start_date) {
          $shiftControl = new ShiftControl($request->All());
          $shiftControl->service_request_id = $serviceRequest->id;
          $shiftControl->start_date = $shift_start_date . " " .$request->shift_start_hour[$key];
          $shiftControl->end_date = $request->shift_end_date[$key] . " " .$request->shift_end_hour[$key];
          $shiftControl->observation = $request->shift_observation[$key];
          $shiftControl->save();
        }
      }

      //get responsable_id organization in charge
      $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', $request->responsable_id);
      $employee = User::find($request->responsable_id)->position;
      if ($authorities!=null) {
        $employee = $authorities[0]->position;// . " - " . $authorities[0]->organizationalUnit->name;
        $ou_id = $authorities[0]->organizational_unit_id;
      }else{
        $ou_id = User::find($request->responsable_id)->organizational_unit_id;
      }

      //se crea la primera firma
      $SignatureFlow = new SignatureFlow($request->All());
      $SignatureFlow->user_id = Auth::id();
      $SignatureFlow->ou_id = $ou_id;
      $SignatureFlow->service_request_id = $serviceRequest->id;
      $SignatureFlow->type = "creador";
      $SignatureFlow->employee = $employee;
      $SignatureFlow->signature_date = Carbon::now();
      $SignatureFlow->status = 1;
      $SignatureFlow->sign_position = 1;
      $SignatureFlow->save();

      //firmas seleccionadas en la vista
      $sign_position = 2;
      if($request->users <> null){
        foreach ($request->users as $key => $user) {

          //saber la organizationalUnit que tengo a cargo
          $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', User::find($user)->id);
          $employee = User::find($user)->position;
          if ($authorities!=null) {
            $employee = $authorities[0]->position;
            $ou_id = $authorities[0]->organizational_unit_id;
          }else{
            $ou_id = User::find($user)->organizational_unit_id;
          }

          $SignatureFlow = new SignatureFlow($request->All());
          $SignatureFlow->ou_id = $ou_id;
          $SignatureFlow->responsable_id = User::find($user)->id;
          $SignatureFlow->user_id = Auth::id();//User::find($user)->id;
          $SignatureFlow->service_request_id = $serviceRequest->id;
          $SignatureFlow->type = "visador";
          $SignatureFlow->employee = $employee;
          $SignatureFlow->sign_position = $sign_position;
          $SignatureFlow->save();

          $sign_position = $sign_position + 1;
        }
      }

      //send emails (2 flow position)
      if (env('APP_ENV') == 'production') {
        $email = $serviceRequest->SignatureFlows->where('sign_position',2)->first()->user->email;
        Mail::to($email)->send(new ServiceRequestNotification($serviceRequest));
      }

      session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido creada.');
      // session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido creada. Para visualizar el certificado de confirmación, hacer click <a href="'. route('rrhh.service_requests.certificate-pdf', $SignatureFlow) . '" target="_blank">Aquí.</a>');
      return redirect()->route('rrhh.service_requests.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function show(ServiceRequest $serviceRequest)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function edit(ServiceRequest $serviceRequest)
  {
      //validate users without permission Service Request: additional data
      if (!Auth::user()->can('Service Request: additional data')) {
        $user_id = Auth::user()->id;
        if ($serviceRequest->signatureFlows->where('responsable_id',$user_id)->count() == 0 &&
            $serviceRequest->signatureFlows->where('user_id',$user_id)->count() == 0) {
          session()->flash('danger','No tiene acceso a esta solicitud');
          return redirect()->route('rrhh.service_requests.index');
        }
      }

      $users = User::orderBy('name','ASC')->get();
      $establishments = Establishment::orderBy('name', 'ASC')->get();

      $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->orderBy('name', 'ASC')->get();
      $responsabilityCenters = OrganizationalUnit::orderBy('name', 'ASC')->get();

      $SignatureFlow = $serviceRequest->SignatureFlows->where('employee','Supervisor de servicio')->first();

      //saber la organizationalUnit que tengo a cargo
      $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
      $employee = Auth::user()->position;
      if ($authorities!=null) {
        $employee = $authorities[0]->position . " - " . $authorities[0]->organizationalUnit->name;
      }

      return view('service_requests.requests.edit', compact('serviceRequest', 'users', 'establishments', 'subdirections', 'responsabilityCenters', 'SignatureFlow','employee'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ServiceRequest $serviceRequest)
  {
      //se guarda información de la solicitud
      $serviceRequest->fill($request->all());
      $serviceRequest->save();

      //guarda control de turnos
      if ($request->shift_start_date!=null) {
        //se elimina historico
        ShiftControl::where('service_request_id',$serviceRequest->id)->delete();
        //ingreso info.
        foreach ($request->shift_start_date as $key => $shift_start_date) {
          $shiftControl = new ShiftControl($request->All());
          $shiftControl->service_request_id = $serviceRequest->id;
          $shiftControl->start_date = Carbon::parse($shift_start_date . " " .$request->shift_start_hour[$key]);
          $shiftControl->end_date = Carbon::parse($request->shift_end_date[$key] . " " .$request->shift_end_hour[$key]);
          $shiftControl->observation = $request->shift_observation[$key];
          $shiftControl->save();
        }
      }

      session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido modificada.');
      return redirect()->route('rrhh.service_requests.index');
  }

  public function update_aditional_data(Request $request, ServiceRequest $serviceRequest)
  {
      //se guarda información de la solicitud
      $serviceRequest->fill($request->all());
      $serviceRequest->save();

      session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido modificada.');
      return redirect()->route('rrhh.service_requests.aditional_data_list');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function destroy(ServiceRequest $serviceRequest)
  {
      $serviceRequest->delete();
      session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido eliminada.');
      return redirect()->route('rrhh.service_requests.index');

  }

  public function consolidated_data(Request $request)
  {

    //solicitudes activas
    $serviceRequests = ServiceRequest::whereDoesntHave("SignatureFlows", function($subQuery) {
                                         $subQuery->where('status',0);
                                       })
                                       // ->whereBetween('start_date',[$request->dateFrom,$request->dateTo])
                                       ->orderBy('request_date','asc')->get();

    foreach ($serviceRequests as $key => $serviceRequest) {
      foreach ($serviceRequest->shiftControls as $key => $shiftControl) {
        $start_date = Carbon::parse($shiftControl->start_date);
        $end_date = Carbon::parse($shiftControl->end_date);
        $dateDiff=$start_date->diffInHours($end_date);
        $serviceRequest->ControlHrs += $dateDiff;
      }
    }

    //solicitudes Rechazadas
    $serviceRequestsRejected = ServiceRequest::whereHas("SignatureFlows", function($subQuery) {
                                         $subQuery->where('status',0);
                                       })
                                       // ->whereBetween('start_date',[$request->dateFrom,$request->dateTo])
                                       ->orderBy('request_date','asc')->get();

    foreach ($serviceRequestsRejected as $key => $serviceRequest) {
      foreach ($serviceRequest->shiftControls as $key => $shiftControl) {
        $start_date = Carbon::parse($shiftControl->start_date);
        $end_date = Carbon::parse($shiftControl->end_date);
        $dateDiff=$start_date->diffInHours($end_date);
        $serviceRequest->ControlHrs += $dateDiff;
      }
    }

    return view('service_requests.requests.consolidated_data',compact('serviceRequests','serviceRequestsRejected'));
  }


  public function export_sirh() {
    // foreach ($serviceRequests as $key => $serviceRequest) {
    //   foreach ($serviceRequest->shiftControls as $key => $shiftControl) {
    //     $start_date = Carbon::parse($shiftControl->start_date);
    //     $end_date = Carbon::parse($shiftControl->end_date);
    //     $dateDiff=$start_date->diffInHours($end_date);
    //     $serviceRequest->ControlHrs += $dateDiff;
    //   }
    // }
    // dd($serviceRequests);
    //return view('service_requests.requests.consolidated_data',compact('serviceRequests'));

    $headers = array(
        "Content-type" => "plain/txt",
        "Content-Disposition" => "attachment; filename=export_sirh.txt",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $filas = ServiceRequest::where('establishment_id',1)->get();
              // ->where('sirh_contract_registration',0)->orWhereNull('sirh_contract_registration')
              // ->whereDoesntHave("SignatureFlows", function($subQuery) {
              //   $subQuery->where('status',0);
              // })
              // ->orderBy('request_date','asc')
              // ->get();

    $columnas = array(
        'RUN',
        'DV',
        'N° cargo',
        'Fecha inicio contrato',
        'Fecha fin contrato',
        'Establecimiento',
        'Tipo de decreto',
        'Contrato por prestación',
        'Monto bruto',
        'Número de cuotas',
        'Impuesto',
        'Día de proceso',
        'Honorario suma alzada',
        'Financiado proyecto',
        'Centro de costo',
        'Unidad',
        'Tipo de pago',
        'Código de banco',
        'Cuenta bancaria',
        'Programa',
        'Glosa',
        'Profesión',
        'Planta',
        'Resolución',
        'N° resolución',
        'Fecha resolución',
        'Observación',
        'Función',
        'Descripción de la función que cumple',
        'Estado tramitación del contrato',
        'Tipo de jornada',
        'Agente público',
        'Horas de contrato',
        'Código por objetivo',
        'Función dotación',
        'Tipo de función',
        'Afecto a sistema de turno'
    );


    // echo '<pre>';
    $callback = function() use ($filas, $columnas)
    {
        $file = fopen('php://output', 'w');
        fwrite($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        fputcsv($file, $columnas,'|', ' ');
        foreach($filas as $fila) {
          if(!$fila->resolution_number or !$fila->resolution_date) {


          list($run,$dv) = explode('-',$fila->rut);
          $cuotas = $fila->end_date->month - $fila->start_date->month + 1;

          switch($fila->program_contract_type) {
            case 'Horas':
              $por_prestacion = 'S';
              $sirh_n_cargo = 6;
              break;
            default:
              $por_prestacion = 'N';
              $sirh_n_cargo = 5;
              break;
          }

          switch($fila->establishment->id) {
            case 1:  $sirh_estab_code=130; break;
            case 12: $sirh_estab_code=127; break;
            case 38: $sirh_estab_code=125; break;
            default: $sirh_estab_code=0; break;
          }

          switch($fila->programm_name){
            case 'Covid19 Médicos': $sirh_program_code = 3904; break;
            case 'Covid19 No Médicos': $sirh_program_code = 3903; break;
            case 'Covid19-APS Médicos': $sirh_program_code = 3904; break;
            case 'Covid19-APS No Médicos': $sirh_program_code = 3903; break;
          }

          switch($fila->weekly_hours) {
            case 44: $type_of_day = 'C'; break;
            default: $type_of_day = 'P'; break;
          }

          switch($fila->estate) {
            case 'Administrativo':
              $function = 'Apoyo Administrativo';
              $function_type = 'N';
              break;
            default:
              $function = 'Apoyo Clínico';
              $function_type = 'S';
              break;
          }

          switch($fila->working_day_type){
            case 'DIURNO': $turno_afecto = 'S'; break;
            default: $turno_afecto = 'N'; break;
          }

          switch($fila->responsabilityCenter->id) {
            case 	12	:	$sirh_ou_id = 1253000	; break;
            case 	55	:	$sirh_ou_id = 1305102	; break;
            case 	18	:	$sirh_ou_id = 1301400	; break;
            case 	224	:	$sirh_ou_id = 1253000	; break;
            case 	225	:	$sirh_ou_id = 1252000	; break;
            case 	43	:	$sirh_ou_id = 1304407	; break;
            case 	116	:	$sirh_ou_id = 1301620	; break;
            case 	138	:	$sirh_ou_id = 1301401	; break;
            case 	130	:	$sirh_ou_id = 1301650	; break;
            case 	141	:	$sirh_ou_id = 1301310	; break;
            case 	142	:	$sirh_ou_id = 1301320	; break;
            case 	136	:	$sirh_ou_id = 1301420	; break;
            case 	133	:	$sirh_ou_id = 1301410	; break;
            case 	140	:	$sirh_ou_id = 1301650	; break;
            case 	2	:	  $sirh_ou_id = 1253000	; break;
            case 	125	:	$sirh_ou_id = 1301509	; break;
            case 	194	:	$sirh_ou_id = 1301905	; break;
            case 	177	:	$sirh_ou_id = 1301650	; break;
            case 	192	:	$sirh_ou_id = 1301904	; break;
            case 	162	:	$sirh_ou_id = 1301523	; break;
            case 	122	:	$sirh_ou_id = 1304105	; break;
            case 	99	:	$sirh_ou_id = 1305102	; break;
            case 	147	:	$sirh_ou_id = 1301203	; break;
            case 	126	:	$sirh_ou_id = 1302108	; break;
            case 	149	:	$sirh_ou_id = 1301202	; break;
            case  24  : $sirh_ou_id = 1301400 ; break;
            default   : $sirh_ou_id = 'NO EXISTE'; break;
          }

          switch($fila->estate) {
            case "Profesional Médico":  $planta = 0; break;
            case "Profesional":         $planta = 4; break;
            case "Técnico":             $planta = 5; break;
            case "Administrativo":      $planta = 6; break;
            case "Farmaceutico":        $planta = 3; break;
            case "Odontólogo":          $planta = 1; break;
            case "Bioquímico":          $planta = 2; break;
            case "Auxiliar":            $planta = 7; break;
            default:                    $planta = ''; break;
            // - 0 = Médicos
            // - 1 = Odontologos
            // - 2 = Bioquimicos
            // - 3 = Quimicos Farmaceuticos
            // - 4 = Profesional
            // - 5 = Técnicos
            // - 6 = Administrativos
            // - 7 = Auxiliares
          }

          switch($fila->rrhh_team) {
            case "Residencia Médica":
              $sirh_profession_id=1000;
              $sirh_function_id=9082; // Antención clínica
              break;
            case "Médico Diurno":
              $sirh_profession_id=1000;
              $sirh_function_id=9082; // Atención clínica
              break;
            case "Enfermera Supervisora":
              $sirh_profession_id=1058;
              $sirh_function_id=9082; // Atención clínica
              break;
            case "Enfermera Diurna":
              $sirh_profession_id=1058;
              $sirh_function_id=9082; // Atención clínica
              break;
            case "Enfermera Turno":
              $sirh_profession_id=1058;
              $sirh_function_id=9082; // Atención clínica
              break;
            case "Kinesiólogo Diurno":
              $sirh_profession_id=1057;
              $sirh_function_id=9082; // Atención clínica
              break;
            case "Kinesiólogo Turno":
              $sirh_profession_id=1057;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Téc.Paramédicos Diurno":
              $sirh_profession_id=1027;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Téc.Paramédicos Turno":
              $sirh_profession_id=1027;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Auxiliar Diurno":
              $sirh_profession_id=111;
              $sirh_function_id=9083; // Apoyo Administrativo
              break;
            case "Auxiliar Turno":
              $sirh_profession_id=111;
              $sirh_function_id=9083; // Apoyo Administrativo
              break;
            case "Terapeuta Ocupacional":
              $sirh_profession_id=1055;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Químico Farmacéutico":
              $sirh_profession_id=320;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Bioquímico":
              $sirh_profession_id=1003;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Fonoaudiologo":
              $sirh_profession_id=1319;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Administrativo Diurno":
              $sirh_profession_id=119;
              $sirh_function_id=9083; // Apoyo Administrativo
              break;
            case "Administrativo Turno":
              $sirh_profession_id=119;
              $sirh_function_id=9083; // Apoyo Administrativo
              break;
            case "Biotecnólogo Turno":
              $sirh_profession_id=513;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Matrona Turno":
              $sirh_profession_id=1060;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Matrona Diurno":
              $sirh_profession_id=1060;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Otros técnicos":
              $sirh_profession_id=530;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Psicólogo":
              $sirh_profession_id=1160;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Tecn. Médico Diurno":
              $sirh_profession_id=1316;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Tecn. Médico Turno":
              $sirh_profession_id=1316;
              $sirh_function_id=9082; // Atención Clínica
              break;
            case "Trabajador Social":
              $sirh_profession_id=1020;
              $sirh_function_id=9082; // Atención Clínica
              break;
          }


          $data = array(
            $run,
            $dv,
            $sirh_n_cargo, // contrato 5, prestaión u hora extra es 6
            $fila->start_date->format('d/m/Y'),
            $fila->end_date->format('d/m/Y'),
            $sirh_estab_code,
            'S',
            $por_prestacion,
            $fila->gross_amount,
            $cuotas, // calculado entre fecha de contratos
            'S',
            '5',
            'S',
            'S',
            '18',
            $sirh_ou_id,
            '1', // cheque
            '0', // tipo de banco 0 o 1
            '0', // cuenta 0
            $sirh_program_code, // 3903 (no medico) 3904 (medico)
            '24', // Glosa todos son 24
            $sirh_profession_id,
            $planta,
            '0', // Todas son excentas = 0
            ($fila->resolution_number) ? $fila->resolution_number : 1,
            ($fila->resolution_date) ? $fila->resolution_date->format('d/m/Y') : '15/02/2021',
            substr($fila->digera_strategy,0,99), // maximo 100
            $sirh_function_id,
            preg_replace( "/\r|\n/", " ", substr($fila->service_description,0,254)), // max 255
            'A',
            $type_of_day, // calcular en base a las horas semanales y tipo de contratacion
            'N',
            $fila->weekly_hours,
            '2103001', // único para honorarios
            'N',
            $function_type, // Apoyo asistenciasl S o N
            $turno_afecto // working_day_type Diurno = S, el resto N
          );
          //print_r($data);
          fputs($file, implode('|',$data)."\n");


          } // if de sólo sin numero de resolucion
        }
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);

  }

    public function resolution(ServiceRequest $ServiceRequest)
    {
        return view('service_requests.report_resolution', compact('ServiceRequest'));
    }

    public function resolutionPDF(ServiceRequest $ServiceRequest)
    {
        $rut = explode("-", $ServiceRequest->rut);
        $ServiceRequest->run_s_dv = number_format($rut[0],0, ",", ".");
        $ServiceRequest->dv = $rut[1];

        $formatter = new NumeroALetras();
        $ServiceRequest->gross_amount_description = $formatter->toWords($ServiceRequest->gross_amount, 0);

        if ($ServiceRequest->fulfillments) {
          foreach ($ServiceRequest->fulfillments as $key => $fulfillment) {
            $fulfillment->total_to_pay_description = $formatter->toWords($fulfillment->total_to_pay, 0);
            // dd($fulfillment->total_to_pay_description);
          }
        }

        // dd($ServiceRequest->fulfillments);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('service_requests.report_resolution',compact('ServiceRequest'));

        return $pdf->stream('mi-archivo.pdf');
        // return view('service_requests.report_resolution', compact('serviceRequest'));
        // $pdf = \PDF::loadView('service_requests.report_resolution');
        // return $pdf->stream();
    }

    public function derive(Request $request){

      $user_id = Auth::user()->id;
      $sender_name = User::find(Auth::user()->id)->getFullNameAttribute();
      $receiver_name = User::find($request->derive_user_id)->getFullNameAttribute();
      $receiver_email = User::find($request->derive_user_id)->email;

      $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                           $subQuery->whereNull('status');
                                           $subQuery->where('responsable_id',$user_id);
                                         })
                                         ->orderBy('id','asc')
                                         ->get();

      $cont = 0;
      $cant_rechazados = 0;
      foreach ($serviceRequests as $key => $serviceRequest) {
        if ($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0) {
          $cant_rechazados += 1;
        }
        else{
          foreach ($serviceRequest->SignatureFlows->where('responsable_id',$user_id)->whereNull('status') as $key2 => $signatureFlow) {
            $signatureFlow->responsable_id = $request->derive_user_id;
            $signatureFlow->derive_date = Carbon::now();
            $signatureFlow->employee = $signatureFlow->employee . " (Traspasado desde ".$sender_name.")";
            $signatureFlow->save();
            $cont += 1;
          }
        }
      }

      //send emails
      if ($cont > 0) {
        if (env('APP_ENV') == 'production') {
          Mail::to($receiver_email)->send(new DerivationNotification($cont,$sender_name,$receiver_name));
        }
      }

      session()->flash('info', $cont . ' solicitudes fueron derivadas.');
      return redirect()->route('rrhh.service_requests.index');
    }


    public function corrige_firmas(){
      // $serviceRequests = ServiceRequest::whereIn('id',[
      // 383,385,390,396,398,399,400,404,405,406,407,410,411,412,414,427,428,430,431,432,433,434,435,436,437,438,439,440,441,442,443,446,447,450,451,452,453,
      // 458,459,464,473,484,489,493,494,502,504,505,506,507,508,510,511,512,513,514,517,519,520,521,522,523,524,557,565,566,567,568,569,571,573,574,577,578,
      // 579,580,582,583,584,585,586,588,589,592,597,598,599,601,602,603,604,605,606,607,608,609,610,611,612,613,614,615,616,617,618,619,622,623,627,629,630])
      // ->get();
      //
      // foreach ($serviceRequests as $key => $serviceRequest) {
      //
      //   foreach ($serviceRequest->SignatureFlows as $key => $SignatureFlow) {
      //     if($SignatureFlow->sign_position > 2){
      //       $SignatureFlow->sign_position += 1;
      //       $SignatureFlow->save();
      //     }
      //   }
      //
      //   if ($serviceRequest->subdirection_ou_id == 85) {
      //
      //     $SignatureFlow = new SignatureFlow();
      //     $SignatureFlow->ou_id = $serviceRequest->subdirection_ou_id;
      //     $SignatureFlow->responsable_id = 13835321;
      //     $SignatureFlow->user_id = 13835321;
      //     $SignatureFlow->service_request_id = $serviceRequest->id;
      //     $SignatureFlow->type = "visador";
      //     $SignatureFlow->employee = "Subdirector SGCP";
      //     $SignatureFlow->sign_position = 3;
      //     $SignatureFlow->save();
      //
      //   }else{
      //
      //     $SignatureFlow = new SignatureFlow();
      //     $SignatureFlow->ou_id = $serviceRequest->subdirection_ou_id;
      //     $SignatureFlow->responsable_id = 9882506;
      //     $SignatureFlow->user_id = 9882506;
      //     $SignatureFlow->service_request_id = $serviceRequest->id;
      //     $SignatureFlow->type = "visador";
      //     $SignatureFlow->employee = "Subdirector Médico";
      //     $SignatureFlow->sign_position = 3;
      //     $SignatureFlow->save();
      //
      //   }
      // }
      // dd("terminó");

    }

    public function pending_requests(Request $request)
    {
      //solicitudes activas
      $serviceRequests = ServiceRequest::orderBy('id','asc')
                                       // ->whereBetween('start_date',[$request->dateFrom,$request->dateTo])
                                       ->get();

      $array = [];
      foreach ($serviceRequests as $key => $serviceRequest) {
        $total = 0;
        $cant_aprobados = 0;
        $cant_rechazados = 0;
        $falta_aprobar = "";
        foreach ($serviceRequest->SignatureFlows as $key => $SignatureFlow) {
          $total += 1;
          if ($SignatureFlow->status == 1) {
            $cant_aprobados += 1;
          }
          if ($SignatureFlow->status === 0) {
            $cant_rechazados += 1;
          }
          if (!($cant_rechazados > 0)) {
            if ($total != $cant_aprobados) {
              $falta_aprobar = $serviceRequest->SignatureFlows->whereNull('status')->sortBy('sign_position')->first()->user->getFullNameAttribute();
            }
          }

        }
        $array[$serviceRequest->id]['objeto'] = $serviceRequest;
        $array[$serviceRequest->id]['total'] = $total;
        $array[$serviceRequest->id]['aprobados'] = $cant_aprobados;
        $array[$serviceRequest->id]['rechazados'] = $cant_rechazados;
        $array[$serviceRequest->id]['falta_aprobar'] = $falta_aprobar;
      }

      //obtener subtotales
      $group_array = [];
      $hoja_ruta_falta_aprobar = 0;
      foreach ($array as $key => $data) {
        $group_array[$data['falta_aprobar']] = 0;
        // $group_array['rechazados'] = 0;
      }
      foreach ($array as $key => $data) {
        if ($data['rechazados'] == 0 && $data['falta_aprobar'] != "") {
          $group_array[$data['falta_aprobar']] += 1;
          $hoja_ruta_falta_aprobar+=1;
        }
      }

      arsort($group_array);
      // dd($group_array);


      $serviceRequests = ServiceRequest::orderBy('id','asc')
                                       // ->whereBetween('start_date',[$request->dateFrom,$request->dateTo])
                                      ->where('program_contract_type','Mensual')
                                      ->whereDoesntHave("SignatureFlows", function($subQuery) {
                                                  $subQuery->where('status',0);
                                                })
                                      ->whereDoesntHave("SignatureFlows", function($subQuery) {
                                                  $subQuery->whereNull('status');
                                                })
                                       ->get();


      //cumplimiento
      $fulfillments_missing = [];
      $cumplimiento_falta_ingresar = 0;
      foreach ($serviceRequests as $key => $serviceRequest) {
        if ($serviceRequest->Fulfillments->count() == 0) {
          if ($serviceRequest->SignatureFlows->where('sign_position',2)->count() > 0) {
            $fulfillments_missing[$serviceRequest->SignatureFlows->where('sign_position',2)->first()->user->getFullNameAttribute()][$serviceRequest->SignatureFlows->where('sign_position',2)->first()->organizationalUnit->name] = 0;
          }
        }
      }

      foreach ($serviceRequests as $key => $serviceRequest) {
        if ($serviceRequest->Fulfillments->count() == 0) {
          if ($serviceRequest->SignatureFlows->where('sign_position',2)->count() > 0) {
            $cumplimiento_falta_ingresar += 1;
            $fulfillments_missing[$serviceRequest->SignatureFlows->where('sign_position',2)->first()->user->getFullNameAttribute()][$serviceRequest->SignatureFlows->where('sign_position',2)->first()->organizationalUnit->name] += 1;
          }
        }
      }

      arsort($fulfillments_missing);
      // dd($fulfillments_missing);

      return view('service_requests.requests.pending_requests',compact('array','group_array','hoja_ruta_falta_aprobar','fulfillments_missing','cumplimiento_falta_ingresar'));
    }

    public function certificatePDF(ServiceRequest $serviceRequest)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('service_requests.requests.report_certificate',compact('serviceRequest'));

        return $pdf->stream('mi-archivo.pdf');
    }

}
