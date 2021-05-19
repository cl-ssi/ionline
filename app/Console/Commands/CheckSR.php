<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceRequests\ServiceRequest;
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
        $srs = ServiceRequest::where('program_contract_type','Mensual')->get();
        $ct = 1;
        foreach($srs as $sr) {
            $diferencia = $sr->end_date->month - $sr->start_date->month + 1 ;
            // if( $diferencia < count($sr->fulfillments)  ) {
            //     echo $ct . ") " . $sr->id . " " . $sr->program_contract_type 
            //     . " " . $sr->working_day_type . " ";
            //     echo $sr->start_date->format('Y-m-d') ." ". $sr->end_date->format('Y-m-d') . " ";
            //     echo $sr->end_date->month - $sr->start_date->month + 1 . " => ";
            //     echo count($sr->fulfillments). " \n ";
            //     $ct++;

            //     $array_real = null;
            //     for($i = $sr->start_date->month; $i <= $sr->end_date->month; $i++) {
            //         $array_real[] = $i;
            //     }
            //     //print_r($array_real);

            //     $array_malo = null;
            //     foreach($sr->fulfillments as $f) {
            //         if(in_array($f->month, $array_real) === false) {
            //             echo "eliminar fulfillment: " . $f->id . "\n"; 
            //         }
            //         $array_malo[] = $f->month;
            //     }
            //     //print_r($array_malo);
            // }

            if( $diferencia > count($sr->fulfillments)  ) {
                echo $ct . ") " . $sr->id . " " . $sr->program_contract_type 
                . " " . $sr->working_day_type . " ";
                echo $sr->start_date->format('Y-m-d') ." ". $sr->end_date->format('Y-m-d') . " ";
                echo $sr->end_date->month - $sr->start_date->month + 1 . " => ";
                echo count($sr->fulfillments). " \n ";
                $ct++;

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
                    }
                    else {
                        $fecha_tmp = new Carbon($sr->start_date->year.'-'.$i.'-1');
                        $array_real[$i]['type'] = 'xx';
                        $array_real[$i]['start_date'] = $fecha_tmp;
                        $array_real[$i]['end_date']   = $fecha_tmp->endOfMonth();
                        $array_real[$i]['year']       = $fecha_tmp->year;
                        $array_real[$i]['month']      = $fecha_tmp->month;
                    }
                    
                    
                }
                print_r($array_real);

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
