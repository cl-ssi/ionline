<?php

namespace App\Http\Controllers\His;

use Illuminate\Http\Request;
use App\Models\His\ModificationRequest;
use App\Http\Controllers\Controller;

class ModificationRequestController extends Controller
{
    public function __invoke(Request $request, ModificationRequest $modificationRequest)
    {
        $documentFile = \PDF::loadView('his.modification-request-show', compact('modificationRequest'));
        return $documentFile->stream();
    }
}
