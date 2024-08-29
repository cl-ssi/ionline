<?php

namespace App\Livewire\Mammography;

use Livewire\Component;
use App\Models\Mammography\MammographySlot;
use App\Models\Mammography\MammographyDay;
use App\Models\Mammography;

class Book extends Component
{
    public $mammography;
    public $slot;
    public $telephone;
    public $key;

    public function booking($slot){
        $this->slot = MammographySlot::find($slot);
        $this->slot->update(['used' => $this->slot->used + 1]);
        $this->slot->day->update(['exam_used' => $this->slot->day->exam_used + 1]);
        // $this->mammography->update(['exam_date' => $this->slot->start_at,
        //                             'telephone' => $this->telephone]);

        $this->mammography->exam_date = $this->slot->start_at;
        $this->mammography->telephone = $this->telephone;
        $this->mammography->save();
    }

    public function render()
    {
        if(is_null($this->mammography->first_dose_at)) {
            $slots = MammographySlot::all();
            $days = MammographyDay::all();
        }
        else {
            $slots = MammographySlot::whereDate('start_at', $this->mammography->first_dose_at->add('month',1) )->get();
            $days = array(); // no es necesaria esta variable para la segunda dosis
        }
        return view('livewire.mammography.book')
            ->withSlots($slots)
            ->withMammography($this->mammography)
            ->withDays($days);
    }
}
