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

      // $serviceRequestsPendings = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
      //                                              $subQuery->where('responsable_id',$user_id)->whereNull('status');
      //                                            })->orderBy('id','asc')
      //                                            ->whereDoesntHave("SignatureFlows", function($subQuery) {
      //                                              $subQuery->where('status',0)->whereNull('status'); //que no haya un rechazado
      //                                            })
      //                                            ->where('responsable_id','!=',Auth::user()->id)
      //                                            ->get();
      //
      // $myServiceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
      //                                        $subQuery->where('user_id',$user_id)->orWhere('responsable_id',$user_id)->whereNotNull('status');
      //                                      })->orderBy('id','asc')->get();

      $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                           $subQuery->where('responsable_id',$user_id);
                                           $subQuery->orwhere('user_id',$user_id);
                                         })
                                         ->orderBy('id','asc')
                                         ->get();

      foreach ($serviceRequests as $key => $serviceRequest) {
        //not rejected
        if ($serviceRequest->SignatureFlows->where('status','0')->count() == 0) {
          foreach ($serviceRequest->SignatureFlows as $key => $signatureFlow) {

            //with responsable_id
            if ($user_id == $signatureFlow->responsable_id) {
              if ($signatureFlow->status == NULL) {
                //verification if i have to sign or other person
                if ($key > 0) {
                  if ($serviceRequest->SignatureFlows[$key-1]->status == NULL) {
                    $serviceRequestsOthersPendings[$serviceRequest->id] = $serviceRequest;
                  }
                  else{
                    $serviceRequestsMyPendings[$serviceRequest->id] = $serviceRequest;
                  }
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

      // dd($serviceRequestsMyPendings, $serviceRequestsRejected);

      foreach ($serviceRequests as $key => $serviceRequest) {
        if (!array_key_exists($serviceRequest->id,$serviceRequestsOthersPendings)) {
          if (!array_key_exists($serviceRequest->id,$serviceRequestsMyPendings)) {
            if (!array_key_exists($serviceRequest->id,$serviceRequestsAnswered)) {
              $serviceRequestsCreated[$serviceRequest->id] = $serviceRequest;
            }
          }
        }
      }

      // dd($serviceRequestsCreated);
      // dd($serviceRequestsOthersPendings, $serviceRequestsMyPendings, $serviceRequestsAnswered);

      return view('service_requests.requests.index', compact('serviceRequestsMyPendings','serviceRequestsOthersPendings','serviceRequestsRejected','serviceRequestsAnswered','serviceRequestsCreated','users'));
  }

  public function aditional_data_list(){

    $serviceRequests = ServiceRequest::orderBy('id','asc')->get();
    return view('service_requests.requests.aditional_data_list', compact('serviceRequests'));
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
       $signatureFlows['S.G.D.P Hospital'] = 9018101; // 86 - Subdirección de Gestión de Desarrollo de las Personas
       $signatureFlows['Jefe Finanzas'] = 13866194; // 11 - Departamento de Finanzas
       $signatureFlows['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
       $signatureFlows['Director Hospital'] = 14101085; // 84 - Dirección

       $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
       $responsabilityCenters = OrganizationalUnit::where('establishment_id',1)
                                                  ->where('name','LIKE','%unidad%')
                                                  ->orwhere('name','LIKE','%servicio%')
                                                  ->orwhere('name','LIKE','%estadio%')
                                                  ->orwhere('name','LIKE','%covid%')
                                                  ->orderBy('name', 'ASC')->get();
     }
    //another
     else{
       session()->flash('info', 'Usted no posee una unidad organizacional válida para ingresar hojas de ruta.');
       return redirect()->back();
     }

    // $signatureFlows['Subdirector'] = 9882506; // 88 - Subdirección Médica
    // $signatureFlows['S.D.G.A SSI'] = 14104369; // 2 - Subdirección de Gestion Asistencial / Subdirección Médica
    // $signatureFlows['S.G.D.P Hospital'] = 9018101; // 86 - Subdirección de Gestión de Desarrollo de las Personas
    // $signatureFlows['Jefe Finanzas'] = 13866194; // 11 - Departamento de Finanzas
    // $signatureFlows['S.G.D.P SSI'] = 15685508; // 44 - Subdirección de Gestión y Desarrollo de las Personas
    // $signatureFlows['Director Hospital'] = 14101085; // 84 - Dirección

     // dd($signatureFlows);

    return view('service_requests.requests.create', compact('subdirections','responsabilityCenters','users','establishments','signatureFlows'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
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

      //saber la organizationalUnit que tengo a cargo
      // $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
      // $employee = Auth::user()->position;
      // if ($authorities!=null) {
      //   $employee = $authorities[0]->position;// . " - " . $authorities[0]->organizationalUnit->name;
      //   $ou_id = $authorities[0]->organizational_unit_id;
      // }else{
      //   $ou_id = Auth::user()->organizational_unit_id;
      // }

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

      // if (Auth::user()->organizationalUnit->establishment_id == 38) {
      //
      //   $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',38)->orderBy('name', 'ASC')->get();
      //   $responsabilityCenters = OrganizationalUnit::where('establishment_id',38)->get();
      //
      // }else{
      //
      //   $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
      //   $responsabilityCenters = OrganizationalUnit::where('establishment_id',1)
      //                                              ->where('name','LIKE','%unidad%')
      //                                              ->orwhere('name','LIKE','%servicio%')
      //                                              ->orwhere('name','LIKE','%estadio%')
      //                                              ->orwhere('name','LIKE','%covid%')
      //                                              ->orderBy('name', 'ASC')->get();
      // }

        $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->orderBy('name', 'ASC')->get();
        $responsabilityCenters = OrganizationalUnit::orderBy('name', 'ASC')->get();

      $SignatureFlow = $serviceRequest->SignatureFlows->where('employee','Supervisor de servicio')->first();

      //saber la organizationalUnit que tengo a cargo
      $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
      $employee = Auth::user()->position;
      if ($authorities!=null) {
        $employee = $authorities[0]->position . " - " . $authorities[0]->organizationalUnit->name;
      }

      // dd($SignatureFlow);
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
      //
  }

  public function consolidated_data()
  {
    $serviceRequests = ServiceRequest::whereDoesntHave("SignatureFlows", function($subQuery) {
                                         $subQuery->where('status',0);
                                       })
                                       ->orderBy('request_date','asc')->get();

    foreach ($serviceRequests as $key => $serviceRequest) {
      foreach ($serviceRequest->shiftControls as $key => $shiftControl) {
        $start_date = Carbon::parse($shiftControl->start_date);
        $end_date = Carbon::parse($shiftControl->end_date);
        $dateDiff=$start_date->diffInHours($end_date);
        $serviceRequest->ControlHrs += $dateDiff;
      }
    }

    return view('service_requests.requests.consolidated_data',compact('serviceRequests'));
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
        "Content-Disposition" => "attachment; filename=export_sirh.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $filas = ServiceRequest::whereDoesntHave("SignatureFlows", function($subQuery) {
                               $subQuery->where('status',0);
                             })
                             ->orderBy('request_date','asc')->get();

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

    $callback = function() use ($filas, $columnas)
    {
        $file = fopen('php://output', 'w');
        fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        fputcsv($file, $columnas,';');
        foreach($filas as $fila) {
          list($run,$dv) = explode('-',$fila->rut);
            fputcsv($file, array(
                $run,
                $dv,
                $fila->id, // N° cargo
                $fila->start_date->format('d-m-Y'),
                $fila->end_date->format('d-m-Y'),
                'Establecimiento [130=hospital, ssi=12]',
                'Tipo de decreto [S,N]',
                'Contrato por prestación [S,N]',
                $fila->gross_amount,
                'Número de cuotas [0-12]',
                'Impuesto',
                'Día de proceso',
                'Honorario suma alzada [S,N]',
                'Financiado proyecto [S,N]',
                'Centro de costo [código sirh]',
                'Unidad [código sirh]',
                'Tipo de pago [0=efectivo,1=cheque,2=D.cta.corriente...]',
                'Código de banco [código sirh]',
                'Cuenta bancaria',
                'Programa [código sirh]',
                'Glosa [gódigo sirh asosciado al programa]',
                'Profesión [código sirh]',
                'Planta [0=médicos,1=odontólogos,...]',
                'Resolución[0=exenta,1=toma razon,2=registro,3=proyecto,4=decreto]',
                $fila->resolution_number,
                '$fila->resolution_date',
                'Observacón',
                'Función [código sirh]',
                $fila->service_description,
                'Estado tramitación del contrato [A=Autorizado,T=Tramitado,V=Visado]',
                'Tipo de jornada [C=Completa,P=Parcial,V=Visado]',
                'Agente público [S,N]',
                'Horas de contrato [0,44]',
                'Código por objetivo [Código sirh]',
                'Función dotación [S,N]',
                'Tipo de función [S,N]',
                'Afecto a sistema de turno [S,N]'
            ),';');
        }
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);

  }

    public function resolution(ServiceRequest $serviceRequest)
    {
        return view('service_requests.report_resolution', compact('serviceRequest'));
    }

    public function resolutionPDF(ServiceRequest $ServiceRequest)
    {
        $rut = explode("-", $ServiceRequest->rut);
        $ServiceRequest->run_s_dv = number_format($rut[0],0, ",", ".");
        $ServiceRequest->dv = $rut[1];

        $formatter = new NumeroALetras();
        $ServiceRequest->gross_amount_description = $formatter->toWords($ServiceRequest->gross_amount, 0);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('service_requests.report_resolution',compact('ServiceRequest'));

        return $pdf->stream('mi-archivo.pdf');
        // return view('service_requests.report_resolution', compact('serviceRequest'));
        // $pdf = \PDF::loadView('service_requests.report_resolution');
        // return $pdf->stream();
    }

    public function derive(Request $request){
      $user_id = Auth::user()->id;
      $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                           $subQuery->whereNull('status');
                                           $subQuery->where('responsable_id',$user_id);
                                         })
                                         ->orderBy('id','asc')
                                         ->get();

      foreach ($serviceRequests as $key => $serviceRequest) {
        // $serviceRequest->responsable_id = $request->derive_user_id;
        // $serviceRequest->save();
        foreach ($serviceRequest->SignatureFlows->where('responsable_id',$user_id)->whereNull('status') as $key2 => $signatureFlow) {
          $signatureFlow->responsable_id = $request->derive_user_id;
          $signatureFlow->derive_date = Carbon::now();
          $signatureFlow->save();
        }
      }

      session()->flash('info', 'Las solicitudes fueron derivadas.');
      return redirect()->route('rrhh.service_requests.index');
    }


    public function corrige_firmas(){
      $serviceRequests = ServiceRequest::whereIn('id',[
      383,385,390,396,398,399,400,404,405,406,407,410,411,412,414,427,428,430,431,432,433,434,435,436,437,438,439,440,441,442,443,446,447,450,451,452,453,
      458,459,464,473,484,489,493,494,502,504,505,506,507,508,510,511,512,513,514,517,519,520,521,522,523,524,557,565,566,567,568,569,571,573,574,577,578,
      579,580,582,583,584,585,586,588,589,592,597,598,599,601,602,603,604,605,606,607,608,609,610,611,612,613,614,615,616,617,618,619,622,623,627,629,630])
      ->get();

      foreach ($serviceRequests as $key => $serviceRequest) {

        foreach ($serviceRequest->SignatureFlows as $key => $SignatureFlow) {
          if($SignatureFlow->sign_position > 2){
            $SignatureFlow->sign_position += 1;
            $SignatureFlow->save();
          }
        }

        if ($serviceRequest->subdirection_ou_id == 85) {

          $SignatureFlow = new SignatureFlow();
          $SignatureFlow->ou_id = $serviceRequest->subdirection_ou_id;
          $SignatureFlow->responsable_id = 13835321;
          $SignatureFlow->user_id = 13835321;
          $SignatureFlow->service_request_id = $serviceRequest->id;
          $SignatureFlow->type = "visador";
          $SignatureFlow->employee = "Subdirector SGCP";
          $SignatureFlow->sign_position = 3;
          $SignatureFlow->save();

        }else{

          $SignatureFlow = new SignatureFlow();
          $SignatureFlow->ou_id = $serviceRequest->subdirection_ou_id;
          $SignatureFlow->responsable_id = 9882506;
          $SignatureFlow->user_id = 9882506;
          $SignatureFlow->service_request_id = $serviceRequest->id;
          $SignatureFlow->type = "visador";
          $SignatureFlow->employee = "Subdirector Médico";
          $SignatureFlow->sign_position = 3;
          $SignatureFlow->save();

        }
      }
      dd("terminó");
    }
}
