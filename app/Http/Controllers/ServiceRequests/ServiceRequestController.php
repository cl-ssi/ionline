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

      return view('service_requests.requests.index', compact('serviceRequestsMyPendings','serviceRequestsOthersPendings','serviceRequestsRejected','serviceRequestsAnswered','serviceRequestsCreated'));
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

    // $subdirections = Subdirection::orderBy('name', 'ASC')->get();
    // $responsabilityCenters = ResponsabilityCenter::orderBy('name', 'ASC')->get();
    $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
    $responsabilityCenters = OrganizationalUnit::where('establishment_id',1)
                                               ->where('name','LIKE','%unidad%')
                                               ->orwhere('name','LIKE','%servicio%')
                                               ->orderBy('name', 'ASC')->get();
    // dd($responsabilityCenters);
    return view('service_requests.requests.create', compact('subdirections','responsabilityCenters','users','establishments'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //valida que usuario tenga ou
      if($request->users <> null){
        foreach ($request->users as $key => $user) {

          //saber la organizationalUnit que tengo a cargo
          $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', User::find($user)->id);
          $employee = User::find($user)->position;
          if ($authorities!=null) {
            $employee = $authorities[0]->position . " - " . $authorities[0]->organizationalUnit->name;
            $ou_id = $authorities[0]->organizational_unit_id;
          }else{
            $ou_id = User::find($user)->organizational_unit_id;
          }

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
            $employee = $authorities[0]->position . " - " . $authorities[0]->organizationalUnit->name;
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
      $email = $serviceRequest->SignatureFlows->where('sign_position',2)->first()->user->email;
      Mail::to($email)->send(new ServiceRequestNotification($serviceRequest));

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
      $user_id = Auth::user()->id;
      if ($serviceRequest->signatureFlows->where('responsable_id',$user_id)->count() == 0 &&
          $serviceRequest->signatureFlows->where('user_id',$user_id)->count() == 0) {
        session()->flash('danger','No tiene acceso a esta solicitud');
        // return redirect()->back();
        return redirect()->route('rrhh.service_requests.index');
      }

      // $subdirections = Subdirection::orderBy('name', 'ASC')->get();
      // $responsabilityCenters = ResponsabilityCenter::orderBy('name', 'ASC')->get();
      $users = User::orderBy('name','ASC')->get();
      $establishments = Establishment::orderBy('name', 'ASC')->get();
      // $organizationalUnits = organizationalUnit::where('establishment_id',1)->orderBy('name', 'ASC')->get();
      // $subdirections = organizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
      // $responsabilityCenters = organizationalUnit::where('name','LIKE','%unidad%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
      $subdirections = OrganizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
      $responsabilityCenters = OrganizationalUnit::where('establishment_id',1)
                                                 ->where('name','LIKE','%unidad%')
                                                 ->orwhere('name','LIKE','%servicio%')
                                                 ->orderBy('name', 'ASC')->get();
      $SignatureFlow = $serviceRequest->SignatureFlows->where('employee','Supervisor de servicio')->first();
      // $my_level = null;
      // $position = null;
      // if (Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id) != null) {
      //   $my_level = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id)[0]->organizationalUnit->level;
      //   $position = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id)->position;
      // }

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
          // $shiftControl->start_date = Carbon::createFromFormat('d/m/Y H:i', $shift_start_date . " " .$request->shift_start_hour[$key]); //d/m/Y
          // $shiftControl->end_date = Carbon::createFromFormat('d/m/Y H:i', $request->shift_end_date[$key] . " " .$request->shift_end_hour[$key]); //d/m/Y
          $shiftControl->start_date = Carbon::parse($shift_start_date . " " .$request->shift_start_hour[$key]);
          $shiftControl->end_date = Carbon::parse($request->shift_end_date[$key] . " " .$request->shift_end_hour[$key]);
          $shiftControl->observation = $request->shift_observation[$key];
          $shiftControl->save();
        }
      }

      session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido modificada.');
      return redirect()->route('rrhh.service_requests.index');
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
    $serviceRequests = ServiceRequest::orderBy('request_date','asc')->get();
    foreach ($serviceRequests as $key => $serviceRequest) {
      foreach ($serviceRequest->shiftControls as $key => $shiftControl) {
        $start_date = Carbon::parse($shiftControl->start_date);
        $end_date = Carbon::parse($shiftControl->end_date);
        $dateDiff=$start_date->diffInHours($end_date);
        $serviceRequest->ControlHrs += $dateDiff;
      }
    }
    // dd($serviceRequests);
    return view('service_requests.requests.consolidated_data',compact('serviceRequests'));
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
}
