<?php

namespace App\Http\Livewire\Authorities;

use Livewire\Component;
use Carbon\Carbon;
use App\User;

class Calendar extends Component
{
    public $monthSelection;
    public $startOfMonth;
    public $data;

    public $edit = true;
    
    /**
    * Mount
    */
    public function mount()
    {
        $this->monthSelection = date('Y-m');
    }
    public function render()
    {

        $this->startOfMonth = Carbon::createFromFormat('Y-m', $this->monthSelection)->startOfMonth();
        
        /** Array de prueba */
        $this->data = array();

        $date = $this->startOfMonth->copy();
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(1);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = true;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);
        
        $date = $this->startOfMonth->copy()->addDays(2);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(3);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(4);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(5);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        // dd($this->data);

        return view('livewire.authorities.calendar');
    }
}
