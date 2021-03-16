<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function toPay(){
        /* 2 querys con listado de fullfillment pendientes y pagados */

        $current_week = date('Y').'-W'.date('W');
        return view('service_requests.reports.to_pay', compact('current_week'));
    }
}
