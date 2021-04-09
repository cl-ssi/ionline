<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\FulfillmentItem;
use App\Models\ServiceRequests\ShiftControl;

use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;

class ShiftControlLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ShiftPum';

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
      //shift controls
      $fulfillmentItems = FulfillmentItem::all();
      foreach ($fulfillmentItems as $key => $fulfillmentItem) {
        //verifica que tenga servicerequest vigente (no eliminado)
        if ($fulfillmentItem->fulfillment) {
          if ($fulfillmentItem->fulfillment->serviceRequest) {
            //solo turnos
            if ($fulfillmentItem->type == "Turno") {
              //que no tenga shiftcontrols
              if ($fulfillmentItem->fulfillment->serviceRequest->shiftControls->count() == 0) {
                // dd($fulfillmentItem->fulfillment->service_request_id);
                print_r($fulfillmentItem->fulfillment->id . "-" .$fulfillmentItem->id . " \n");
                $shiftControl = new ShiftControl();
                $shiftControl->fulfillment_id = $fulfillmentItem->fulfillment->id;
                $shiftControl->start_date = $fulfillmentItem->start_date;
                $shiftControl->end_date = $fulfillmentItem->end_date;
                $shiftControl->observation = $fulfillmentItem->observation;
                $shiftControl->save();
              }
            }
          }
          else{
            $fulfillmentItem->fulfillment->delete();
            $fulfillmentItem->delete();
          }
        }
      }

      print_r(" \n\n crea fulfillments que falten");

      //crea fulfillments que falten
      $serviceRequests = ServiceRequest::all();
      foreach ($serviceRequests as $key => $serviceRequest) {
        if ($serviceRequest->fulfillments->count() == 0) {

          //############ guarda cumplimiento ##############

          $start    = new DateTime($serviceRequest->start_date);
          $start->modify('first day of this month');
          $end      = new DateTime($serviceRequest->end_date);
          $end->modify('first day of next month');
          $interval = DateInterval::createFromDateString('1 month');
          $periods   = new DatePeriod($start, $interval, $end);
          $cont_periods = iterator_count($periods);

          // crea de forma automática las cabeceras
          if ($serviceRequest->program_contract_type == "Mensual" || ($serviceRequest->program_contract_type == "Horas" && $serviceRequest->working_day_type == "HORA MÉDICA")) {
            if ($serviceRequest->fulfillments->count() == 0) {
              foreach ($periods as $key => $period) {
                $program_contract_type = "Mensual";
                $start_date_period = $period->format("d-m-Y");
                $end_date_period = Carbon::createFromFormat('d-m-Y', $period->format("d-m-Y"))->endOfMonth()->format("d-m-Y");
                if($key == 0){
                  $start_date_period = $serviceRequest->start_date->format("d-m-Y");
                }
                if (($cont_periods - 1) == $key) {
                  $end_date_period = $serviceRequest->end_date->format("d-m-Y");
                  $program_contract_type = "Parcial";
                }

                $fulfillment = new Fulfillment();
                $fulfillment->service_request_id = $serviceRequest->id;
                if ($serviceRequest->program_contract_type == "Mensual") {
                  $fulfillment->year = $period->format("Y");
                  $fulfillment->month = $period->format("m");
                }else{
                  $program_contract_type = "Horas Médicas";
                  $fulfillment->year = $period->format("Y");
                  $fulfillment->month = $period->format("m");
                }
                $fulfillment->type = $program_contract_type;
                $fulfillment->start_date = $start_date_period;
                $fulfillment->end_date = $end_date_period;
                // $fulfillment->user_id = Auth::user()->id;
                $fulfillment->user_id = $serviceRequest->creator_id;
                $fulfillment->save();

                print_r($fulfillment->id  . " \n");
              }
            }
          }

          elseif($serviceRequest->program_contract_type == "Horas"){
            if ($serviceRequest->fulfillments->count() == 0) {
              $fulfillment = new Fulfillment();
              $fulfillment->service_request_id = $serviceRequest->id;
              $fulfillment->type = "Horas No Médicas";
              $fulfillment->year = $serviceRequest->start_date->format("Y");
              $fulfillment->month = $serviceRequest->start_date->format("m");
              $fulfillment->start_date = $serviceRequest->start_date;
              $fulfillment->end_date = $serviceRequest->end_date;
              // $fulfillment->user_id = Auth::user()->id;
              $fulfillment->user_id = $serviceRequest->creator_id;
              $fulfillment->save();

              print_r("xxx:".$fulfillment->id  . " \n");
            }else {
              $fulfillment = $serviceRequest->fulfillments->first();
            }
          }

          // ################### fin guarda cumplimiento #######################


        }
      }





        return 0;
    }
}
