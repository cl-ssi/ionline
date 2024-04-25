<?php

namespace App\Http\Livewire\Trainings;

use Livewire\Component;

use App\Models\Trainings\Training;

class SearchTraining extends Component
{
    public $index;

    public $bootstrap;

    public function render()
    {
        if(auth()->guard('external')->check() == true){
            return view('livewire.trainings.search-training', [
                'trainings' => training::latest()
                    ->where('user_training_id', auth()->id())
                    ->whereNull('organizational_unit_id')
                    ->paginate(50)
            ]);
        }
        else{
            if($this->index == 'own'){
                return view('livewire.trainings.search-training', [
                    'trainings' => training::latest()
                    ->where('user_training_id', auth()->id())
                    ->orWhere('user_creator_id', auth()->id())
                    ->whereNotNull('organizational_unit_id')
                    ->paginate(50)
                ]);
            }
            if($this->index == 'all'){
                return view('livewire.trainings.search-training', [
                    'trainings' => training::latest()
                    ->paginate(50)
                ]);
            }
        }

        // return view('livewire.trainings.search-training');
    }
}
