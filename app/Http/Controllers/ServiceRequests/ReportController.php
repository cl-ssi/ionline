<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequests\Fulfillment;
use Carbon\Carbon;

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

        if ($request->week != NULL) {
          $current_week = $request->week;
        }else{
          $current_week = date('Y').'-W'.date('W');
        }

        $now = Carbon::now();
        list($year, $week) = explode('-W',$current_week);
        $now->setISODate($year,$week);
        $from = $now->startOfWeek()->format('Y-m-d 00:00:00');
        $to   = $now->endOfWeek()->format('Y-m-d 23:59:59');


        $fulfillments = Fulfillment::whereHas("ServiceRequest", function($subQuery) use($from,$to){
                                       $subQuery->whereBetween('request_date',[$from,$to]);
                                     })
                                     ->get();

        // dd($fulfillments);
        return view('service_requests.reports.to_pay', compact('current_week','fulfillments'));
    }
}
