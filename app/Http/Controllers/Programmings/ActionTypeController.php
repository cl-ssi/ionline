<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programmings\ActionType;

class ActionTypeController extends Controller
{
    public function index()
    {
        $actiontypes = ActionType::All()->SortBy('id');
        return view('programmings/actionType/index')->withActionTypes($actiontypes);
    }
}
