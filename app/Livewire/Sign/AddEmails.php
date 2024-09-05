<?php

namespace App\Livewire\Sign;

use Livewire\Component;

class AddEmails extends Component
{
    public $typeDestination;
    public $destinations;
    public $destination;
    public $eventName;

    public function mount()
    {
        $this->destinations = collect();
        $this->typeDestination = "email";
    }

    public function render()
    {
        return view('livewire.sign.add-emails');
    }

    public function addEmail()
    {
        $rules = [
            'destination' => 'required|string|min:5|max:255',
        ];

        if($this->typeDestination == "email")
        {
            $rules = [
                'destination' => 'required|email',
            ];
        }

        $this->validate($rules);

        $destination['type'] = $this->typeDestination;
        $destination['destination'] = $this->destination;

        $this->destinations->push($destination);

        $this->destination = null;

        $this->dispatch($this->eventName, emails: $this->destinations);

        $this->typeDestination = "email";

    }
}
