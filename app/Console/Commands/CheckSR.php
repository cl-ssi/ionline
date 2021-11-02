<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use Carbon\Carbon;

class CheckSR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckSR';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Solamente para los mensuales
        //$srs = ServiceRequest::where('program_contract_type','Mensual')->get();
        // ahora comando para los horas y TURNO DE REEMPLAZO
        //working_day_type == "TURNO DE REEMPLAZO"
        //$srs = ServiceRequest::where('program_contract_type','horas')->where('working_day_type','TURNO DE REEMPLAZO')->get();
        //$srs = ServiceRequest::where('program_contract_type','horas')->where('working_day_type','HORA MÉDICA')->get();
        $srs = ServiceRequest::all();
        $ct = 1;
        foreach($srs as $sr) {
            $diferencia = $sr->end_date->month - $sr->start_date->month + 1 ;             
            if( $diferencia < count($sr->fulfillments)  ) {
                echo $ct . ") " . $sr->id . " " . $sr->program_contract_type 
                . " " . $sr->working_day_type . " ";
                echo $sr->start_date->format('Y-m-d') ." ". $sr->end_date->format('Y-m-d') . " ";
                echo $sr->end_date->month - $sr->start_date->month + 1 . " => ";
                echo count($sr->fulfillments). " \n ";
                $ct++;
                //echo'soy menor';

                $array_real = null;
                for($i = $sr->start_date->month; $i <= $sr->end_date->month; $i++) {
                    $array_real[] = $i;
                }
                echo'array real es \n';
                print_r($array_real);

                $array_malo = null;
                foreach($sr->fulfillments as $f) {
                    if(in_array($f->month, $array_real) === false) {
                        echo "eliminar fulfillment: " . $f->id . " del service request " .$sr->id. "\n"; 
                        $f->delete();
                    }
                    $array_malo[] = $f->month;
                }
                //print_r($array_malo);
            }

            if( $diferencia > count($sr->fulfillments)  ) {
                echo $ct . ") " . $sr->id . " " . $sr->program_contract_type 
                . " " . $sr->working_day_type . " ";
                echo $sr->start_date->format('Y-m-d') ." ". $sr->end_date->format('Y-m-d') . " ";
                echo $sr->end_date->month - $sr->start_date->month + 1 . " => ";
                echo count($sr->fulfillments). " \n ";
                $ct++;
                // echo'soy mayor';

                $array_real = null;
                for($i = $sr->start_date->month; $i <= $sr->end_date->month; $i++) {
                    $array_real[$i]['service_request_id'] = $sr->id;

                    /* Primer cumplimiento */
                    if($i == $sr->start_date->month AND $i == $sr->end_date->month) {
                        if($sr->start_date->day == 1 AND $sr->start_date->endOfMonth()->day == $sr->start_date->day) {
                            $array_real[$i]['type'] = 'Mensual';
                        }
                        else {
                            $array_real[$i]['type'] = 'Parcial';
                        }
                        $array_real[$i]['start_date'] = $sr->start_date;
                        $array_real[$i]['end_date']   = $sr->end_date;
                        $array_real[$i]['year']       = $sr->start_date->year;
                        $array_real[$i]['month']      = $sr->start_date->month;
                        $array_real[$i]['user_id']    = $sr->creator_id;
                    }
                    else if($i == $sr->start_date->month) {
                        if($sr->start_date->day == $sr->start_date->firstOfMonth()->day){
                            $array_real[$i]['type'] = 'Mensual';
                        }
                        else {
                            $array_real[$i]['type'] = 'Parcial';
                        }
                        $array_real[$i]['start_date'] = $sr->start_date;
                        $array_real[$i]['end_date']   = $sr->start_date->endOfMonth();
                        $array_real[$i]['year']       = $sr->start_date->year;
                        $array_real[$i]['month']      = $sr->start_date->month;
                        $array_real[$i]['user_id']    = $sr->creator_id;
                    }
                    else if($i == $sr->end_date->month) {
                        if($sr->end_date->day == $sr->end_date->endOfMonth()->day){
                            $array_real[$i]['type'] = 'Mensual';
                        }
                        else {
                            $array_real[$i]['type'] = 'Parcial';
                        }
                        $array_real[$i]['start_date'] = $sr->end_date->firstOfMonth();
                        $array_real[$i]['end_date']   = $sr->end_date;
                        $array_real[$i]['year']       = $sr->end_date->year;
                        $array_real[$i]['month']      = $sr->end_date->month;
                        $array_real[$i]['user_id']    = $sr->creator_id;
                    }
                    else {
                        $fecha_start = new Carbon($sr->start_date->year.'-'.$i.'-1');
                        $fecha_end   = new Carbon($sr->start_date->year.'-'.$i.'-1');
                        $array_real[$i]['type'] = 'Mensual';
                        $array_real[$i]['start_date'] = $fecha_start;
                        $array_real[$i]['end_date']   = $fecha_end->endOfMonth();
                        $array_real[$i]['year']       = $fecha_start->year;
                        $array_real[$i]['month']      = $fecha_start->month;
                        $array_real[$i]['user_id']    = $sr->creator_id;
                    }
                    
                    
                }
                echo("////////Comienzo agregar ///////////"). " \n ";
                print_r($array_real);
                // Fulfillment::create([
                //     'destination' => 'LAX',
                //     'origin' => 'LHR',
                //     'last_flown' => '2020-03-04 11:00:00',
                //     'last_pilot_id' => 747,
                // ]);
                Fulfillment::insert($array_real);
                echo("////////Fin agregar ///////////"). " \n ";

                // $array_malo = null;
                // foreach($sr->fulfillments as $f) {
                //     if(in_array($f->month, $array_real) === false) {
                //         echo "eliminar " . $f->id . "\n"; 
                //     }
                //     $array_malo[] = $f->month;
                // }
                //print_r($array_malo);
            }
            
            /*
            id
            service_reqeust_id
            año
            mes
            tipo (mensual o parcial)

             */
        }
        return 0;
    }
}
