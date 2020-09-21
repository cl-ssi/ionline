<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\Professional;

class ProfessionalController extends Controller
{
    public function index()
    {
        $professionals = Professional::All()->SortBy('name');
        return view('programmings/professionals/index')->withProfessionals($professionals);
    }
}
