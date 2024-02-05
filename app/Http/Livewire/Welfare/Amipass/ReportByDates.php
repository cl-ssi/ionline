<?php

namespace App\Http\Livewire\Welfare\Amipass;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;

use App\Models\Parameters\Holiday;
use App\Models\Rrhh\AmiLoad;
use App\Models\Welfare\Amipass\Charge;
use App\Models\Rrhh\CompensatoryDay;
use App\Models\Rrhh\AbsenteeismType;

class ReportByDates extends Component
{

    // public $finicio;
    // public $ftermino;
    public $search_date;
    public $userWithContracts;
    public $output;

    protected $rules = [
        // 'finicio' => 'required',
        // 'ftermino' => 'required',
        'search_date' => 'required'
    ];

    // public function mount(){
    //     $this->finicio = Carbon::createFromDate('2023-02-01');
    //     $this->ftermino = Carbon::createFromDate('2023-02-28');
    // }

    public function search(){

        $this->validate();

        // format fechas
        $dateMonthArray = explode('-', $this->search_date);
        $year = $dateMonthArray[0];
        $month = $dateMonthArray[1];

        $startDate = Carbon::createFromDate($year, $month)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month)->endOfMonth();

        // Se deben obtener los feriados del mes siguiente, por ende se suma un mes a la fecha de analisis
        $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

        $start = $startDate->copy();
        $holidays_search_start_date = $start->addMonth();
        $holidays_search_end_date = $holidays_search_start_date->copy()->endOfMonth();
        $holidaysNextMonth = Holiday::whereBetween('date', [$holidays_search_start_date, $holidays_search_end_date])->get();

        // se obtiene id del ausentismo descanso compensatorio
        $compensatoryAbsenteeismType = AbsenteeismType::find(5);
        
        /* Obtener los usuarios que tienen contratos en un rango de fecha con sus ausentismos */
        $this->userWithContracts = User::with([
                'contracts' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                                ->whereDate('fecha_termino_contrato', '>=', $startDate);
                    })->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                            ->whereNull('fecha_termino_contrato');
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
                        ->whereNotNull('fecha_inicio_contrato')
                        ->whereDate('fecha_termino_contrato', '>=', $startDate);
                        // ->where('shift',0); se traen todos, abajo se hace el filtro
                })->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                        ->whereNull('fecha_termino_contrato');
                        // ->where('shift',0); se traen todos, abajo se hace el filtro
                });
            })
            // ->whereIn('id',[10266979])
            ->get(); 
            
            // dd($this->userWithContracts);

        foreach($this->userWithContracts as $row => $user) {
            $user = $user->getAmipassData($startDate, 
                                        $endDate, 
                                        $holidays, 
                                        $holidaysNextMonth,
                                        $compensatoryAbsenteeismType);

            // para exportación
            $this->output[$user->id] = $user->ammount;
        }
    }

    public function export()
    {   
        return response()->streamDownload(function () {
            foreach($this->output as $key => $row){
                echo $key.";".$row.";\r\n";
            }
        }, 'export.txt');

    }

    public function render()
    {
        return view('livewire.welfare.amipass.report-by-dates')->extends('layouts.bt4.app');
    }
}
