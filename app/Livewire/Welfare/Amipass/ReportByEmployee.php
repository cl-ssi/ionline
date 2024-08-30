<?php

namespace App\Livewire\Welfare\Amipass;

use App\Models\Welfare\Amipass\Charge;
use App\Models\Welfare\Amipass\NewCharge;
use App\Models\Welfare\Amipass\Regularization;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Helpers\DateHelper;
use App\Models\Rrhh\AbsenteeismType;
use App\Models\Parameters\Holiday;
use Livewire\Attributes\On;
use Livewire\Component;

// use App\Models\Rrhh\CompensatoryDay

class ReportByEmployee extends Component
{
    public $records;
    public $regularizations;
    public $new_records;
    public $user_id;
    public $calculatedData = [];
    public $year;

    public function mount(){
        $this->year = now()->format('Y');
    }

    #[On('reportByEmployeeEmit')]
    public function reportByEmployeeEmit($userId)
    {
        $this->user_id = $userId;
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

        $this->calculatedData = [];
        $this->userWithContracts = null;
        
        // aqui obtener info como en report by dates
        $start = $this->year.'-01-01';
        $end = $this->year.'-12-31';
        
        $compensatoryAbsenteeismType = AbsenteeismType::find(5); // dias compensatorios
        $periods = CarbonPeriod::create($start, '1 month', $end);

        foreach($periods as $period){
            $startDate = $period->copy();
            $endDate = $period->endOfMonth();

            $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

            // Se deben obtener los feriados del mes siguiente, por ende se suma un mes a la fecha de analisis
            $holidays_search_start_date = $startDate->addMonth();
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
            ->whereIn('id',[$this->user_id])
            ->get();  
            
            // dd($this->userWithContracts);

            if($this->userWithContracts->count() > 0){
                $this->calculatedData[$startDate->format('Y-m')] = $this->userWithContracts->first()->getAmipassData($startDate,
                                                                                                                    $endDate,
                                                                                                                    $holidays,
                                                                                                                    $holidaysNextMonth,
                                                                                                                    $compensatoryAbsenteeismType);   
            }
        }
    }

    public function render()
    {
        return view('livewire.welfare.amipass.report-by-employee')->extends('layouts.bt4.app');
    }
}
