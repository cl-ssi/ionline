<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceRequests\ServiceRequest;

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
        $srs = ServiceRequest::all();
        $ct = 1;
        foreach($srs as $sr) {
            $diferencia = $sr->end_date->month - $sr->start_date->month + 1 ;
            if( $diferencia != count($sr->fulfillments)  ) {
                echo $ct . ") " . $sr->id . " " . $sr->program_contract_type 
                . " " . $sr->working_day_type . " ";
                echo $sr->start_date->format('Y-m-d') ." ". $sr->end_date->format('Y-m-d') . " ";
                echo $sr->end_date->month - $sr->start_date->month + 1 . " => ";
                echo count($sr->fulfillments). " \n ";
                $ct++;
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
