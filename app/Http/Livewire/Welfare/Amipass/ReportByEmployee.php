<?php

namespace App\Http\Livewire\Welfare\Amipass;

use App\Models\Welfare\Amipass\Charge;
use App\Models\Welfare\Amipass\NewCharge;
use App\Models\Welfare\Amipass\Regularization;
use App\User;

use Carbon\Carbon;

use Livewire\Component;

// use App\Models\Rrhh\CompensatoryDay;

class ReportByEmployee extends Component
{
    public $records;
    public $regularizations;
    public $new_records;
    public $user_id;

    protected $listeners = ['reportByEmployeeEmit', 'reportByEmployeeEmit'];

    public function reportByEmployeeEmit(User $user_id)
    {
        $this->user_id = $user_id->id;
    }

    public function search(){
        $this->records = Charge::where('rut', $this->user_id)->get();
        $meses[] = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
        foreach($this->records as $key => $record){
            list($day, $month, $year) = explode('-', $record->fecha);
            // si no es la fecha actual, se elimina de la colecctión
            if($year != Carbon::now()->format('y')){
                unset($this->records[$key]);
            }
        }

        $this->regularizations = Regularization::where('rut', $this->user_id)->get();
        foreach($this->regularizations as $key => $regularization){
            list($day, $month, $year) = explode('-', $regularization->fecha);
            // si no es la fecha actual, se elimina de la colecctión
            if($year != Carbon::now()->format('y')){
                unset($this->regularization[$key]);
            }
        }

        $this->new_records = NewCharge::where('rut', $this->user_id)->get();
        foreach($this->new_records as $key => $new_record){
            list($day, $month, $year) = explode('-', $new_record->fecha);
            // si no es la fecha actual, se elimina de la colecctión
            if($year != Carbon::now()->format('y')){
                unset($this->new_record[$key]);
            }
        }

    }

    public function render()
    {
        return view('livewire.welfare.amipass.report-by-employee');
    }
}
