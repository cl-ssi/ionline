<?php

namespace App\Http\Controllers\Wellness;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WellnessController extends Controller
{
    //
    public function index()
    {
        return view('wellness.index');
    }


/*todo lo que parta con dos corresponde al TXT */
    public function dosindex()
    {        
        return view('wellness.dos.index');
    }
}
