<?php

namespace App\Http\Controllers\Welfare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\models\Welfare\Abscence;
use App\models\Welfare\EmployeeInformation;

class AmipassController extends Controller
{
    public function index()
    {
        $employeeInformations = EmployeeInformation::paginate(50);

        return view('welfare.amipass.dashboard', compact('employeeInformations'));
    }

    public function questionMyIndex()
    {
        
        return view('welfare.amipass.questionmyindex');
    }


}
