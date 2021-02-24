<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use DateTime;
use DatePeriod;
use DateInterval;
use App\User;

use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;

class FulfillmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_id = 10962435;
      $serviceRequests = ServiceRequest::where('rut',$user_id)
                                       ->where('program_contract_type','Mensual') //solo mensuales
                                       ->orderBy('id','asc')
                                       ->get();

       foreach ($serviceRequests as $key => $serviceRequest) {
         //only completed
         if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0 && $serviceRequest->SignatureFlows->whereNull('status')->count() == 0) {

         }else{
           $serviceRequests->forget($key);
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
        $start    = new DateTime($serviceRequest->start_date);
        $start->modify('first day of this month');
        $end      = new DateTime($serviceRequest->end_date);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $periods   = new DatePeriod($start, $interval, $end);

        return view('service_requests.requests.fulfillments.edit',compact('serviceRequest','periods'));
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
}
