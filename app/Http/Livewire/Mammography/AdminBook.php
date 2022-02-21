<?php

namespace App\Http\Livewire\Mammography;

use Livewire\Component;
use App\Models\Vaccination\Slot;
use App\Models\Vaccination\Day;
use App\Models\Vaccination;

class AdminBook extends Component
{
    public $vaccination;
    public $slot;

    public function bookingFirst($slot){
        $this->slot = Slot::find($slot);
        $this->slot->update(['used' => $this->slot->used + 1]);
        $this->slot->day->update(['first_dose_used' => $this->slot->day->first_dose_used + 1]);
        $this->vaccination->update(['first_dose' => $this->slot->start_at]);
    }

    public function bookingSecond($slot){
        $this->slot = Slot::find($slot);
        $this->slot->update(['used' => $this->slot->used + 1]);
        $this->vaccination->update(['second_dose' => $this->slot->start_at]);
    }

    public function render()
    {
        if(is_null($this->vaccination->first_dose_at)) {
            $slots = Slot::all();
            $days = Day::all();
        }
        else {
            $slots = Slot::whereDate('start_at', $this->vaccination->first_dose_at->add('month',1) )->get();
            $days = Day::all(); // para el admin igual se van todos los días
        }
        return view('livewire.vaccination.admin-book')
            ->withSlots($slots)
            ->withVaccination($this->vaccination)
            ->withDays($days);
    }
}

