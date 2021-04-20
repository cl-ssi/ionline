<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;

class ChangeShiftDayStatus extends Component
{	

	public $count = 0;
	public $shiftDay;
	// public $id;

    protected $listeners = ['editShiftDay'];

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
    }
    public function increment()
    {
        // $this->count++;
    }
    public function editShiftDay($id){
    	// $this->shiftDay = ShiftUserDay::find($id);
        $this->count++;

    }
    public function render()
    {
        return view('livewire.rrhh.change-shift-day-status');
    }
}
