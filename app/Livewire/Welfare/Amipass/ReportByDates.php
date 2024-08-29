<?php

namespace App\Livewire\Welfare\Amipass;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;

use App\Models\Parameters\Holiday;
use App\Models\Rrhh\AmiLoad;
use App\Models\Welfare\Amipass\PendingAmount;
use App\Models\Rrhh\CompensatoryDay;
use App\Models\Rrhh\AbsenteeismType;

class ReportByDates extends Component
{

    // public $finicio;
    // public $ftermino;
    public $search_date;
    public $userWithContracts;
    public $userWithContractsArray;
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

        set_time_limit(3600);
        ini_set('memory_limit', '1024M');

        $this->validate();

        // format fechas
        $dateMonthArray = explode('-', $this->search_date);
        $year = $dateMonthArray[0];
        $month = $dateMonthArray[1];

        // se le resta uno al mes en busqueda (porque se busca con la info. del mes anterior)
        $startDate = Carbon::createFromDate($year, $month)->addMonths(-1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month)->addMonths(-1)->endOfMonth();

        // Se deben obtener los feriados del mes siguiente, por ende se suma un mes a la fecha de analisis
        $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

        $start = $startDate->copy();
        $holidays_search_start_date = $start->addMonth();
        $holidays_search_end_date = $holidays_search_start_date->copy()->endOfMonth();
        $holidaysNextMonth = Holiday::whereBetween('date', [$holidays_search_start_date, $holidays_search_end_date])->get();

        // se obtiene id del ausentismo descanso compensatorio
        $compensatoryAbsenteeismType = AbsenteeismType::find(5);

        // fecha del mes anterior para obtener montos pendientes (billetera de debitos)
        $last_month_date = Carbon::parse($year."-".$month."-01");
        $last_month_date = $last_month_date->addMonth(-1);
        
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
                'pendingAmounts' => function ($query) use ($last_month_date) {
                    $query->where(function ($query) use ($last_month_date) {
                        $query->where('year', $last_month_date->year)
                            ->where('month', $last_month_date->month);
                        });
                },
                'absenteeisms.type','charges'
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
            // ->whereIn('id',[10471613])
            ->get(); 
            
            // dd($this->userWithContracts);
            

        foreach($this->userWithContracts as $row => $user) {
            $user = $user->getAmipassData($startDate, 
                                            $endDate, 
                                            $holidays, 
                                            $holidaysNextMonth,
                                            $compensatoryAbsenteeismType);

            // para exportación
            $this->output[$user->id]['shortName'] = $user->shortName;
            $this->output[$user->id]['dailyAmmount'] = $user->dailyAmmount;
            $this->output[$user->id]['shiftAmmount'] = $user->shiftAmmount;
            $this->output[$user->id]['totalAbsenteeisms'] = $user->totalAbsenteeisms;
            $this->output[$user->id]['businessDays'] = $user->businessDays;
            $this->output[$user->id]['contract_hours'] = $user->contract_hours;
            $this->output[$user->id]['totalAbsenteeismsEnBd'] = $user->totalAbsenteeismsEnBd;
            
            // este es el monto que se imprime en pantalla
            $this->output[$user->id]['ammount'] = $user->ammount;

            // este es el monto regularizado para archivo de exportación
            if($user->pendingAmounts->count() > 0){
                $this->output[$user->id]['regularized_ammount'] = $user->ammount + $user->pendingAmounts->first()->consolidated_amount;
            }else{
                $this->output[$user->id]['regularized_ammount'] = $user->ammount;
            }

            $this->output[$user->id]['AmiLoadMount'] = $user->AmiLoadMount;
            $this->output[$user->id]['dias_ausentismo'] = $user->dias_ausentismo;
                         
            $this->output[$user->id]['shifts'] = null;
            if($user->shifts){
                foreach($user->shifts as $key => $shift){
                    $this->output[$user->id]['shifts'][$key]['year'] = $shift->year;
                    $this->output[$user->id]['shifts'][$key]['monthName'] = $shift->monthName();
                    $this->output[$user->id]['shifts'][$key]['quantity'] = $shift->quantity;
                    $this->output[$user->id]['shifts'][$key]['shiftAmmount'] = $shift->shiftAmmount;
                } 
            }

            $this->output[$user->id]['amiLoads'] = null;
            if($user->amiLoads){
                foreach($user->amiLoads as $key => $amiLoad){
                    $this->output[$user->id]['amiLoads'][$key]['fecha'] = $amiLoad->fecha->format('Y-m-d');
                    $this->output[$user->id]['amiLoads'][$key]['monto'] = $amiLoad->monto;
                } 
            }

            $this->output[$user->id]['absenteeisms'] = null;
            if($user->absenteeisms){
                foreach($user->absenteeisms as $key => $absenteeism){
                    $this->output[$user->id]['absenteeisms'][$key]['totalDays'] = $absenteeism->totalDays;
                    $this->output[$user->id]['absenteeisms'][$key]['finicio'] = $absenteeism->finicio->format('Y-m-d');
                    $this->output[$user->id]['absenteeisms'][$key]['ftermino'] = $absenteeism->ftermino->format('Y-m-d');
                    $this->output[$user->id]['absenteeisms'][$key]['tipo_de_ausentismo'] = $absenteeism->tipo_de_ausentismo;
                    $this->output[$user->id]['absenteeisms'][$key]['total_dias_ausentismo'] = $absenteeism->total_dias_ausentismo;
                    $this->output[$user->id]['absenteeisms'][$key]['totalDays'] = $absenteeism->totalDays;
                } 
            }

            $this->output[$user->id]['compensatoryDays'] = null;
            if($user->compensatoryDays){
                foreach($user->compensatoryDays as $key => $compensatoryDay){
                    $this->output[$user->id]['compensatoryDays'][$key]['totalDays'] = $compensatoryDay->totalDays;
                    $this->output[$user->id]['compensatoryDays'][$key]['start_date'] = $compensatoryDay->start_date->format('Y-m-d H:i');
                    $this->output[$user->id]['compensatoryDays'][$key]['end_date'] = $compensatoryDay->end_date->format('Y-m-d H:i');
                    $this->output[$user->id]['compensatoryDays'][$key]['diffInHours'] = $compensatoryDay->start_date->diffInHours($compensatoryDay->end_date);
                    $this->output[$user->id]['compensatoryDays'][$key]['total_dias_ausentismo'] = $compensatoryDay->total_dias_ausentismo;
                    $this->output[$user->id]['compensatoryDays'][$key]['totalDays'] = $compensatoryDay->totalDays;
                    
                } 
            }

            $this->output[$user->id]['contracts'] = null;
            if($user->contracts){
                foreach($user->contracts as $key => $contract){
                    $this->output[$user->id]['contracts'][$key]['id'] = $contract->id;  
                    $this->output[$user->id]['contracts'][$key]['fecha_inicio_contrato'] = optional($contract->fecha_inicio_contrato)->format('Y-m-d');
                    $this->output[$user->id]['contracts'][$key]['fecha_termino_contrato'] = optional($contract->fecha_termino_contrato)->format('Y-m-d');
                    $this->output[$user->id]['contracts'][$key]['numero_horas'] = $contract->numero_horas;       
                } 
            }      
        }

        // $dateMonthArray = explode('-', $this->search_date);
        // $year = $dateMonthArray[0];
        // $month = $dateMonthArray[1];

        PendingAmount::where('year',$year)
                        ->where('month',$month)
                        ->delete();

        $count = 0;
        // dd($this->output);
        foreach($this->output as $key => $item){
            if($item['regularized_ammount'] < 0){
                // crea monto pendiente para el periodo
                $pendingAmount = new PendingAmount();
                $pendingAmount->year = $year;
                $pendingAmount->month = $month;
                $pendingAmount->user_id = $key;
                $pendingAmount->amount = $item['ammount'];
                $pendingAmount->consolidated_amount = $item['regularized_ammount'];
                $pendingAmount->save();

                $this->output[$key]['regularized_ammount'] = 0;

                $this->output[$key]['pendingAmount'] = $item['regularized_ammount'];

                $count += 1;
            }
        }

        session()->flash('message', 'Se detectaron ' . $count . " funcionarios con montos pendientes para próximo período.");

    }

    public function export()
    {   
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');

        return response()->streamDownload(function () {
            foreach($this->output as $key => $row){
                echo $key . ";" . ($row['regularized_ammount'] == "" ? 0 : $row['regularized_ammount']) . ";\r\n";
            }
        }, 'export.txt');

        
    }

    // public function process(){
    //     // format fechas
    //     $dateMonthArray = explode('-', $this->search_date);
    //     $year = $dateMonthArray[0];
    //     $month = $dateMonthArray[1];

    //     PendingAmount::where('year',$date->year)
    //                     ->where('month',$date->month)
    //                     ->delete();

    //     $count = 0;
    //     foreach($this->output as $key => $item){
    //         if($item['ammount'] < 0){
    //             // crea monto pendiente para el periodo
    //             $pendingAmount = new PendingAmount();
    //             $pendingAmount->year = $year;
    //             $pendingAmount->month = $month;
    //             $pendingAmount->user_id = $key;
    //             $pendingAmount->amount = $item['ammount'];
    //             $pendingAmount->save();

    //             $this->output[$key]['ammount'] = 0;
    //             $count += 1;
    //         }
    //     }
    // }

    public function render()
    {
        return view('livewire.welfare.amipass.report-by-dates')->extends('layouts.bt4.app');
    }
}
