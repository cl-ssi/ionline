<?php

namespace App\Livewire\Rrhh;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;

class ChangeShiftDayStatus extends Component
{

    public $count = 0;
	public $loop;
	public $shiftDay;
	public $filered="off";
	// public $id;
    public $actuallyColor;
    protected $listeners = ['renderShiftDay' => '$refresh'];
    private $colors = array(
            1 => "lightblue",
            2 => "#2471a3",
            3 => " #52be80 ",
            4 => "orange",
            5 => "#ec7063",
            6 => "#af7ac5",
            7 => "#f4d03f",
            8 => "gray",
            9  => "yellow",
            10  => "brown",
            11  => "brown",
            12  => "brown",
            13  => "brown",
            14  => "brown",
            15  => "lightred",
            16  => "lightbrown",
    );
    // public function postAdded(Post $post)
    // {
    //     $this->postCount = Post::count();
    //     $this->recentlyAddedPost = $post;
    // }
    public function mount($shiftDay)
    {
        // $this->id = $id;
        // $this->shiftDay = ShiftUserDay::find($id);
        $this->shiftDay =$shiftDay;
        $this->filered = "off";
        $this->actuallyColor  = $this->colors[$shiftDay->status];
    }
    public function increment()
    {
        // $this->count++;
    }

    #[On('changeColor')]
    public function setActuallyColor($color){
        $this->actuallyColor = $color;
    }
    public function editShiftDay(){

		// $this->dispatch('clearModal', $this->shiftDay->id);
    	// $this->filered ="on";
		$this->dispatch('setshiftUserDay', sUDId: $this->shiftDay->id);


    	// $this->shiftDay = ShiftUserDay::find($id);
        // $this->count++;
    	// dd($this->shiftDay);
    }
    public function render()
    {
        return view('livewire.rrhh.change-shift-day-status',["statusColors"=>$this->colors])->extends('layouts.bt4.app');
    }
}
