<?php

namespace App\Livewire\Welfare\Amipass;

use App\Models\Welfare\Amipass\Charge;
use App\Models\Welfare\Amipass\NewCharge;
use App\Models\Welfare\Amipass\Regularization;
use App\Models\Rrhh\AbsenteeismType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Parameters\Holiday;
use App\Models\User;

use Livewire\Component;

class ChargeIndex extends Component
{
    public $year;
    public $calculatedData;

    public function mount(){
        $this->year = now()->format('Y');
    }

    public function render()
    {
        if($this->year == 2023){
            return view('livewire.welfare.amipass.charge-index', [
                'records' => Charge::where('rut', auth()->id())->get(),
                'regularizations' => Regularization::where('rut', auth()->id())->get(),
                'new_records' => NewCharge::where('rut', auth()->id())->get()
            ]);
        }
        else{
            $this->calculatedData = [];
            $this->userWithContracts = null;
            
            // aqui obtener info como en report by dates
            // $start = $this->year.'-01-01';
            // $end = $this->year.'-12-31';
            $start = '2023-01-01';
            $end = '2023-12-31';
            
            $compensatoryAbsenteeismType = AbsenteeismType::find(5); // dias compensatorios
            $periods = CarbonPeriod::create($start, '1 month', $end);
    
            foreach($periods as $period){
                $startDate = $period->copy();
                $endDate = $period->endOfMonth();
    
                // dd($startDate, $endDate);
    
                $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

                // Se deben obtener los feriados del mes siguiente, por ende se suma un mes a la fecha de analisis
                $holidays_search_start_date = $startDate->copy()->addMonth();
                $holidays_search_end_date = $holidays_search_start_date->copy()->endOfMonth();
                $holidaysNextMonth = Holiday::whereBetween('date', [$holidays_search_start_date, $holidays_search_end_date])->get();
                
    
                /* Obtener los usuarios que tienen contratos en un rango de fecha con sus ausentismos */
                $this->userWithContracts = User::with([
                    'contracts' => function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                                    ->whereDate('fecha_termino_contrato', '>=', $startDate);
                                    // ->where('shift',0);
                        });
                    },
                    'absenteeisms' => function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereDate('finicio', '<=', $endDate)
                                ->whereDate('ftermino', '>=', $startDate)
                                ->where('absenteeism_type_id','!=',5);
                            });
                    },
                    'amiLoads' => function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereMonth('fecha',$startDate->month);
                            });
                    },
                    'shifts' => function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->where('year',$startDate->year)
                                    ->where('month',$startDate->month);
                            });
                    },
                    'compensatoryDays' => function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereDate('start_date', '<=', $endDate)
                                ->whereDate('end_date', '>=', $startDate);
                            });
                    },
                    'absenteeisms.type'
                ])
                ->whereHas('contracts', function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                            ->whereDate('fecha_termino_contrato', '>=', $startDate);
                            // ->where('shift',0); se traen todos, abajo se hace el filtro
                    });
                })
                ->whereIn('id',[auth()->id()])
                ->get();  
    
                if($this->userWithContracts->count() > 0){
                    $this->calculatedData[$startDate->format('Y-m')] = $this->userWithContracts->first()->getAmipassData($startDate,
                                                                                                                        $endDate,
                                                                                                                        $holidays,
                                                                                                                        $holidaysNextMonth,
                                                                                                                        $compensatoryAbsenteeismType);   
                }
                
            }

            return view('livewire.welfare.amipass.charge-index');
        }
        
    }
}
