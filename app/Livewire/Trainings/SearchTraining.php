<?php

namespace App\Livewire\Trainings;

use Livewire\Component;

use App\Models\Trainings\Training;
use App\Models\Parameters\Parameter;
use App\Models\Establishment;
use Barryvdh\DomPDF\Facade\Pdf;

class SearchTraining extends Component
{
    public $index;

    public $bootstrap;

    public function render()
    {
        if(auth()->guard('external')->check() == true){
            return view('livewire.trainings.search-training', [
                'trainings' => Training::latest()
                    ->where('user_training_id', auth()->id())
                    ->whereNull('organizational_unit_id')
                    ->paginate(50)
            ]);
        }
        else{
            if($this->index == 'own'){
                return view('livewire.trainings.search-training', [
                    'trainings' => Training::latest()
                    ->where('user_training_id', auth()->id())
                    ->orWhere('user_creator_id', auth()->id())
                    ->whereNotNull('organizational_unit_id')
                    ->paginate(50)
                ]);
            }
            if($this->index == 'all'){
                return view('livewire.trainings.search-training', [
                    'trainings' => Training::latest()
                    ->paginate(50)
                ]);
            }
        }
    }

    public function showSummary(Training $training){
        $establishment = Establishment::Find(Parameter::get('establishment', 'SSTarapaca'));

        return Pdf::loadView('trainings.documents.training_summary_pdf', [
            'training'      => $training,
            'establishment' => $establishment
        ])->stream('download.pdf');
    }
}