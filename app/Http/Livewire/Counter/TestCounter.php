<?php

namespace App\Http\Livewire\Counter;

use Livewire\Component;

class TestCounter extends Component
{

    public $count=2;

    public function increment()
    {
      $this->count++;
    }

    public function decrement()
    {
      $this->count--;
    }



    public function render()
    {
        return view('livewire.counter.test-counter');
    }
}
