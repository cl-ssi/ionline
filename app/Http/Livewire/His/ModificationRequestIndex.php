<?php

namespace App\Http\Livewire\His;

use Livewire\Component;
use App\Models\His\ModificationRequest;

class ModificationRequestIndex extends Component
{
    public function render()
    {
        $modificationRequests = ModificationRequest::latest()->whereCreatorId(auth()->id())->paginate(50);
        return view('livewire.his.modification-request-index', [ 'modifications' => $modificationRequests])->extends('layouts.bt4.app');
    }
}
