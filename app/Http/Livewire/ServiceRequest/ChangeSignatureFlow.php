<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

use App\Models\ServiceRequests\ServiceRequest;
use App\User;

class ChangeSignatureFlow extends Component
{
    public $users;
    public $service_request_id;
    public $user_to_id;
    public $serviceRequests;

    public function mount(){
      $this->users = User::orderBy('name','ASC')->get();
    }

    public function search(){
      $this->serviceRequests = ServiceRequest::find($this->service_request_id);
      $this->users = User::orderBy('name','ASC')->get();
    }

    public function render()
    {
        // $this->users = User::orderBy('name','ASC')->get();
        // $this->serviceRequests = ServiceRequest::find(1);
        // $this->users = User::orderBy('name','ASC')->get();
        return view('livewire.service-request.change-signature-flow');
    }
}
