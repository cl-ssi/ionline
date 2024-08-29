<?php

namespace App\Livewire\Parameters;

use Livewire\Component;
use App\Models\User;

class AccessLogIndex extends Component
{
    public User $user;

    public function render()
    {
        $accessLogs = $this->user->accessLogs();

        return view('livewire.parameters.access-log-index', [
            'accessLogs' => $accessLogs->latest()->paginate(20)
        ]);
    }
}
