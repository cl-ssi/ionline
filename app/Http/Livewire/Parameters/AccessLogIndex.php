<?php

namespace App\Http\Livewire\Parameters;

use Livewire\Component;
use App\User;

class AccessLogIndex extends Component
{
    public User $user;

    public function render()
    {
        $accessLogs = $this->user->accessLogs();

        return view('livewire.parameters.access-log-index', [
            'accessLogs' => $accessLogs->latest()->paginate(10)
        ])->extends('layouts.bt4.app');
    }
}
