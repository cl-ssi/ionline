<?php

namespace App\Http\Controllers\Suitability;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuitabilityController extends Controller
{
    //

    public function index(Request $request)
    {
        //return view('replacement_staff.index', compact('request'));
    }

    public function indexOwn()
    {
        
        return view('suitability.indexown');

    }


    public function validateRequest()
    {
        return view('suitability.validaterequest');
    }


    public function create()
    {
        return view('suitability.create');
    }


}
