<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;

class Authorization extends Component
{
    public $organizationalUnit;

    public function mount(RequestForm $requestForm){
      $this->organizationalUnit = $requestForm->organizationalUnit->name;
    }

    public function acceptRequestForm{

    }

    public function rejectRequestForm{

    }
    public function render(){
        return view('livewire.request-form.authorization');
    }
}
