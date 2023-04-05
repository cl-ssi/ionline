<?php

namespace App\Http\Livewire\Sign;

use Livewire\Component;

class AddEmails extends Component
{
    public $emails;
    public $email;
    public $eventName;
    public $emailRecipients;

    public function mount()
    {
        $this->emails = collect();
    }

    public function render()
    {
        return view('livewire.sign.add-emails');
    }

    public function addEmail()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $this->emails->push($this->email);

        $this->email = null;

        $this->emitUp($this->eventName, $this->emails);

    }
}
