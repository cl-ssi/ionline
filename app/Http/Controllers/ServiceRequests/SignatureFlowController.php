<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequests\SignatureFlow;

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
      // $serviceRequest = new ServiceRequest($request->All());
      // $serviceRequest->save();
      //
      // session()->flash('info', 'La solicitud '.$serviceRequest->id.' ha sido creada.');
      // return redirect()->route('rrhh.service_requests.index');
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
