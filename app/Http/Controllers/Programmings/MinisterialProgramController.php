<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\MinisterialProgram;

class MinisterialProgramController extends Controller
{
    public function index()
    {
        $ministerialprograms = MinisterialProgram::All()->SortBy('id');
        return view('programmings/ministerialProgram/index')->withMinisterialPrograms($ministerialprograms);
    }
}
