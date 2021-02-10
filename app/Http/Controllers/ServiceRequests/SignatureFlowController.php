<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\SignatureFlow;
use App\Mail\ServiceRequestNotification;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;

class SignatureFlowController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      // $serviceRequests = ServiceRequest::orderBy('name', 'ASC')->get();
      // return view('service_requests.requests.index', compact('serviceRequests'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // $subdirections = Subdirection::orderBy('name', 'ASC')->get();
    // $responsabilityCenters = ResponsabilityCenter::orderBy('name', 'ASC')->get();
    // return view('service_requests.requests.create', compact('subdirections','responsabilityCenters'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      if ($request->status != null) {
        //verifica que el proximo usuario corresponde a proximo firmante
        $serviceRequest = ServiceRequest::find($request->service_request_id);
        if ($serviceRequest->SignatureFlows->whereNull('status')->sortBy('sign_position')->first()->responsable_id != Auth::user()->id) {
          session()->flash('danger', "Existe otra persona que debe visar este documento antes que usted.");
          return redirect()->back();
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

        //si seleccionó una opción, se agrega visto bueno.
        if ($request->status != null) {

          $SignatureFlow = SignatureFlow::where('responsable_id',Auth::user()->id)
                                        ->where('service_request_id',$request->service_request_id)
                                        ->whereNull('status')
                                        ->first();

          $SignatureFlow->employee = $request->employee;
          $SignatureFlow->signature_date = Carbon::now();
          $SignatureFlow->status = $request->status;
          $SignatureFlow->observation = $request->observation;
          $SignatureFlow->save();

          //send emails (next flow position)
          $email = $serviceRequest->SignatureFlows->whereNull('status')->sortBy('sign_position')->first()->user->email;
          Mail::to($email)->send(new ServiceRequestNotification($serviceRequest));
       }
      }

      session()->flash('success', 'Se ha registrado la visación.');
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
      // return view('service_requests.requests.edit', compact('serviceRequest', 'subdirections', 'responsabilityCenters'));
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
      // $serviceRequest->fill($request->all());
      // $serviceRequest->save();
      //
      // session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido modificada.');
      // return redirect()->route('rrhh.service_requests.index');
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
}
