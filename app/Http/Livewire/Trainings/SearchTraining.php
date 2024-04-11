<?php

namespace App\Http\Livewire\Trainings;

use Livewire\Component;

use App\Models\Trainings\Training;

class SearchTraining extends Component
{
    public $index;

    public function render()
    {
        if(auth()->guard('external')->check() == true){
            return view('livewire.trainings.search-training', [
                'trainings' => training::latest()
                    ->paginate(50)
            ]);
        }
        else{
            if($this->index == 'own'){
                return view('livewire.trainings.search-training', [
                    'trainings' => training::all()
                ]);
            }
        }

        // return view('livewire.trainings.search-training');
    }
}
