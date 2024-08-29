<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\User;
use App\Notifications\Finance\DteConfirmation;
use App\Models\Finance\Dte;

class DteSendConfirmation extends Component
{
    public $dte;
    public $user;

    /**
     * mount
     */
    public function mount(Dte $dte, $user_id)
    {
        $this->dte = $dte;
        $this->user = User::withTrashed()->find($user_id);
    }

    /**
     * Send Confirmation
     */
    public function sendConfirmation()
    {
        $this->user->notify(new DteConfirmation($this->dte));

        $this->dte->confirmation_sender_id = auth()->id();
        $this->dte->confirmation_send_at = now();
        $this->dte->save();
    }

    public function render()
    {
        return view('livewire.finance.dte-send-confirmation');
    }
}
