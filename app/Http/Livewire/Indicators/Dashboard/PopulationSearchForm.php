<?php

namespace App\Http\Livewire\Indicators\Dashboard;

use Livewire\Component;

use App\Models\Indicators\Establecimiento;

class PopulationSearchForm extends Component
{
    public $selectedYear = null;
    public $selectedEstablishment = null;

    public $establishments = [];

    public function mount($request){
        $this->selectedYear = $request->year;
        $this->selectedEstablishment = $request->establishment_id;

        if($request->type != null){
          $this->establishments = Establecimiento::year($this->selectedYear)
            ->where('tablero_poblacion', 1)
            ->orderBy('comuna')
            ->get();
        }

        $this->dispatchBrowserEvent('contentChanged');
    }

    public function render(){
        return view('livewire.indicators.dashboard.population-search-form', [
          'establishments' => $this->establishments
        ]);
    }

    public function updatedselectedYear($year_id){
        if($year_id != NULL){
            $this->establishments = Establecimiento::year($year_id)
              ->where('tablero_poblacion', 1)
              ->orderBy('comuna')
              ->get();
        }
        else{
            $this->establishments = [];
        }
        $this->dispatchBrowserEvent('contentChanged');
    }
}
