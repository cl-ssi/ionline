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
use App\Rrhh\organizationalUnit;
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
      $resolutionsPending = [];

      $serviceRequestsPendings = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                                   $subQuery->where('user_id',$user_id)->whereNull('status');
                                                 })->orderBy('id','asc')
                                                 ->where('user_id','!=',Auth::user()->id)
                                                 ->get();

      $myServiceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                             $subQuery->where('user_id',$user_id)->whereNotNull('status');
                                           })->orderBy('id','asc')->get();

      return view('service_requests.requests.index', compact('serviceRequestsPendings','myServiceRequests'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $users = User::orderBy('name','ASC')->get();
    // $subdirections = Subdirection::orderBy('name', 'ASC')->get();
    // $responsabilityCenters = ResponsabilityCenter::orderBy('name', 'ASC')->get();
    $subdirections = organizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
    $responsabilityCenters = organizationalUnit::where('name','LIKE','%centro de resp%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
    return view('service_requests.requests.create', compact('subdirections','responsabilityCenters','users'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $serviceRequest = new ServiceRequest($request->All());
      $serviceRequest->rut = $request->run ."-". $request->dv;
      $serviceRequest->user_id = Auth::id();
      $serviceRequest->save();

      //guarda control de turnos
      if ($request->shift_date!=null) {
        foreach ($request->shift_date as $key => $shift_date) {
          // print_r($shift_date . " " .$request->start_hour[$key]);
          $shiftControl = new ShiftControl($request->All());
          $shiftControl->service_request_id = $serviceRequest->id;
          $shiftControl->start_date = $shift_date . " " .$request->shift_start_hour[$key];
          $shiftControl->end_date = $shift_date . " " .$request->shift_end_hour[$key];
          $shiftControl->observation = $request->shift_observation[$key];
          $shiftControl->save();
        }
      }

      //saber la organizationalUnit que tengo a cargo
      $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
      $employee = Auth::user()->position;
      if ($authorities!=null) {
        $employee = $authorities[0]->position;// . " - " . $authorities[0]->organizationalUnit->name;
        $ou_id = $authorities[0]->organizational_unit_id;
      }else{
        $ou_id = Auth::user()->organizational_unit_id;
      }

      //se crea la primera firma
      $SignatureFlow = new SignatureFlow($request->All());
      $SignatureFlow->user_id = Auth::id();
      $SignatureFlow->ou_id = $ou_id;
      $SignatureFlow->service_request_id = $serviceRequest->id;
      $SignatureFlow->type = "visador";
      $SignatureFlow->employee = $employee;
      $SignatureFlow->status = 1;
      $SignatureFlow->save();

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
          $SignatureFlow->user_id = User::find($user)->id;
          $SignatureFlow->service_request_id = $serviceRequest->id;
          $SignatureFlow->type = "visador";
          $SignatureFlow->employee = $employee;
          $SignatureFlow->save();
        }
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
      // $subdirections = Subdirection::orderBy('name', 'ASC')->get();
      // $responsabilityCenters = ResponsabilityCenter::orderBy('name', 'ASC')->get();
      $users = User::orderBy('name','ASC')->get();
      $establishments = Establishment::orderBy('name', 'ASC')->get();
      // $organizationalUnits = organizationalUnit::where('establishment_id',1)->orderBy('name', 'ASC')->get();
      $subdirections = organizationalUnit::where('name','LIKE','%subdirec%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
      $responsabilityCenters = organizationalUnit::where('name','LIKE','%centro de resp%')->where('establishment_id',1)->orderBy('name', 'ASC')->get();
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
      $serviceRequest->rut = $request->run ."-". $request->dv;
      $serviceRequest->save();

      //si seleccionó una opción, se agrega visto bueno.
      if ($request->status != null) {

        //saber la organizationalUnit que tengo a cargo
        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
        $employee = Auth::user()->position;
        if ($authorities!=null) {
          $employee = $authorities[0]->position;// . " - " . $authorities[0]->organizationalUnit->name;
          $ou_id = $authorities[0]->organizational_unit_id;
        }else{
          $ou_id = Auth::user()->organizational_unit_id;
        }

        // $SignatureFlow = new SignatureFlow($request->All());
        // $SignatureFlow->user_id = Auth::id();
        // $SignatureFlow->ou_id = $ou_id;
        // $SignatureFlow->service_request_id = $serviceRequest->id;
        // $SignatureFlow->type = "visador";
        // $SignatureFlow->employee = $employee;
        // $SignatureFlow->save();

        //si seleccionó una opción, se agrega visto bueno.
        if ($request->status != null) {

          $SignatureFlow = SignatureFlow::where('user_id',Auth::user()->id)
                                        ->where('service_request_id',$serviceRequest->id)
                                        ->first();
                                        // dd($SignatureFlow);
          $SignatureFlow->user_id = Auth::id();
          $SignatureFlow->employee = $request->employee;
          $SignatureFlow->status = $request->status;
          $SignatureFlow->save();
       }
      }

      //guarda control de turnos
      if ($request->shift_date!=null) {
        //se elimina historico
        ShiftControl::where('service_request_id',$serviceRequest->id)->delete();
        //ingreso info.
        foreach ($request->shift_date as $key => $shift_date) {
          $shiftControl = new ShiftControl($request->All());
          $shiftControl->service_request_id = $serviceRequest->id;
          $shiftControl->start_date = Carbon::createFromFormat('d/m/Y H:i', $shift_date . " " .$request->shift_start_hour[$key]); //d/m/Y
          $shiftControl->end_date = Carbon::createFromFormat('d/m/Y H:i', $shift_date . " " .$request->shift_end_hour[$key]); //d/m/Y
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
    $serviceRequests = ServiceRequest::orderBy('id','asc')->get();
    return view('service_requests.requests.consolidated_data',compact('serviceRequests'));
  }
}
