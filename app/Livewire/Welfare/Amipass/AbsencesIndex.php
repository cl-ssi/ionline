<?php

namespace App\Livewire\Welfare\Amipass;

use App\Models\Welfare\Amipass\Absence; //tudela
use App\Models\Rrhh\Absenteeism; // rrhh (nuevo)
use Livewire\Component;

class AbsencesIndex extends Component
{
    public $year;
    
    public function mount(){
        $this->year = now()->format('Y');
    }

    public function render()
    {
        if($this->year == 2023){
            return view('livewire.welfare.amipass.absences-index', [
                'records' => Absence::where('rut', auth()->id())->whereYear('fecha_inicio',2023)
                    ->paginate(50),
            ]);
        }else{
            return view('livewire.welfare.amipass.absences-index', [
                'records' => Absenteeism::where('rut', auth()->id())->whereYear('finicio',2023)
                    ->paginate(50),
            ]);
        }
        
    }
}
