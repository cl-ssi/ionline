<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
    * Index
    */
    public function index()
    {
        return view('finance.payments.index');
    }
}
