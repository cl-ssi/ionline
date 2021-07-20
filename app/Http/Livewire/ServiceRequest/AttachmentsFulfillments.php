<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

class AttachmentsFulfillments extends Component
{

    public $inputs = [];
    public $i = 1;    
    public $count = 0;
    public $var;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->count++;
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->count--;
    }

    // public function mount($fullfillment)
    // {
    //     $this->fullfillment  = $fullfillment;
    // }

    public function render()
    {
        //dd($this->fullfillment_id);
        return view('livewire.service-request.attachments-fulfillments');
    }
}
