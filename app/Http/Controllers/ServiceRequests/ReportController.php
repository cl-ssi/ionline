<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function toPay(Request $request){
        /* 2 querys con listado de fullfillment pendientes y pagados */

        // $current_week = date('Y').'-W'.date('W');

        // $now = Carbon::now();
        // $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        // $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
        // $week = $request->week;
        // $current_week = $now->format('Y').'-W'.$now->week();

        // if ($request->week != NULL) {
        //   $current_week = $request->week;
        // }else{
        //   $current_week = date('Y').'-W'.date('W');
        // }
        //
        // $now = Carbon::now();
        // list($year, $week) = explode('-W',$current_week);
        // $now->setISODate($year,$week);
        // $from = $now->startOfWeek()->format('Y-m-d 00:00:00');
        // $to   = $now->endOfWeek()->format('Y-m-d 23:59:59');


        $fulfillments = Fulfillment::whereHas("ServiceRequest", function($subQuery) {
                                       $subQuery->where('has_resolution_file',1);
                                     })
                                     ->where('has_invoice_file',1)
                                     ->get();

        return view('service_requests.reports.to_pay', compact('fulfillments'));
    }

    public function bankPaymentFile()
    {
        // $now = Carbon::now();
        // list($year, $week) = explode('-W', $selected_week);
        // $now->setISODate($year, $week);
        // $from = $now->startOfWeek()->format('Y-m-d 00:00:00');
        // $to = $now->endOfWeek()->format('Y-m-d 23:59:59');
        // $fromFormatted = $now->startOfWeek()->format('d-m-Y');

        // $fulfillments = Fulfillment::whereHas("ServiceRequest", function ($subQuery) use ($from, $to) {
        //     $subQuery->whereBetween('request_date', [$from, $to]);
        // })
        //     ->get();
        $fulfillments = Fulfillment::whereHas("ServiceRequest", function($subQuery) {
                                       $subQuery->where('has_resolution_file',1);
                                     })
                                     ->where('has_invoice_file',1)
                                     ->get();

        $txt = '';
        foreach ($fulfillments as $fulfillment) {
            if (!$fulfillment->serviceRequest->bank) {
                session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene el banco a donde se debe pagar.");
                return redirect()->back();
            }
            if (!$fulfillment->serviceRequest->pay_method) {
                session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene método de pago.");
                return redirect()->back();
            }
            if (!$fulfillment->serviceRequest->account_number) {
                session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene número de cuenta.");
                return redirect()->back();
            }
            if (!$fulfillment->serviceRequest->total_paid) {
                session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene total a pagar.");
                return redirect()->back();
            }

            $txt .= "{$fulfillment->serviceRequest->rut}\t{$fulfillment->serviceRequest->name}\t{$fulfillment->serviceRequest->bank->code}\t{$fulfillment->serviceRequest->pay_method}\t{$fulfillment->serviceRequest->account_number}\t{$fulfillment->total_paid}\n";
        }

        $response = new StreamedResponse();
        $response->setCallBack(function () use ($txt) {
            echo $txt;
        });
        $response->headers->set('Content-Type', 'text/plain');
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, "pago-banco-semana-del-$fromFormatted.txt");
        $response->headers->set('Content-Disposition', $disposition);

        return $response;

    }

    public function pendingResolutions(Request $request){
        $serviceRequests = ServiceRequest::whereNull('has_resolution_file')->orWhere('has_resolution_file','===',0)
                                        ->get();
        foreach ($serviceRequests as $key => $serviceRequest) {
            //only completed
            if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0 && $serviceRequest->SignatureFlows->whereNull('status')->count() == 0) {

            }else{
              $serviceRequests->forget($key);
            }
        }

        // dd($fulfillments);
        return view('service_requests.reports.pending_resolutions', compact('serviceRequests'));
    }

}
