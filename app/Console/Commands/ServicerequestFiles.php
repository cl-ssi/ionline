<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\Rrhh\UserBankAccount;
use App\User;
use DB;

class ServicerequestFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servicerequest:files';

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
        // $srs = ServiceRequest::all();
        // foreach($srs as $sr) {
        //     if($sr->has_resolution_file) {
        //         $name = 'service_request/resolutions/'.$sr->id.'.pdf';
        //         $file = Storage::disk('local')->get($name);
        //         Storage::disk('gcs')->put('ionline/'.$name, $file);
        //         echo $name."\n";
        //     }
        //     foreach($sr->fulfillments as $f){
        //         if($f->has_invoice_file){
        //             $name = 'service_request/invoices/'.$f->id.'.pdf';
        //             $file = Storage::disk('local')->get($name);
        //             Storage::disk('gcs')->put('ionline/'.$name, $file);
        //             echo $name."\n";
        //         }
        //     }
        // }
        // return 0;

        $srs =   DB::table('doc_service_requests')
               ->select('rut', DB::raw('MAX(created_at) as last_created_at'))
               ->where('deleted_at',NULL)
               ->groupBy('rut')
               ->get();

        $array1 = array();
        foreach($srs as $key => $sr) {
          print_r($sr->rut . " " . $sr->last_created_at . " \n");
          $serviceRequest = ServiceRequest::where('rut',$sr->rut)
                                          ->where('created_at',$sr->last_created_at)
                                          ->first();

          $explode_rut = explode("-", str_replace(".","",$serviceRequest->rut));
          $explode_name = explode(" ", $serviceRequest->name);

          //si es que está eliminado, lo vuelve a activar
          if(User::withTrashed()->find($explode_rut[0])){
            if(User::withTrashed()->find($explode_rut[0])->deleted_at != null){
              $user = User::withTrashed()->find($explode_rut[0]);
              $user->restore();
              $user->permissions()->detach();
            }
          }

          //creates-edit user
          if (User::find($explode_rut[0]) == null) {
            $user = new User();
            $user->id = $explode_rut[0];
            $user->dv = $explode_rut[1];
            if (count($explode_name) == 2) {
              $user->name = $explode_name[0];
              $user->fathers_family = $explode_name[1];
              $user->mothers_family ="";
            }
            else{
              $name = $serviceRequest->name;
              $explode = explode(' ',$name);
              $user->mothers_family = array_pop($explode);
              $user->fathers_family = array_pop($explode);
              $user->name = implode(' ',$explode);
            }
            $user->address = $serviceRequest->address;
            $user->phone_number = $serviceRequest->phone_number;
            if ($serviceRequest->nationality == "CHILENA") {
              $user->country_id = 41;
            }
            if ($serviceRequest->nationality == "VENEZOLANA") {
              $user->country_id = 240;
            }
            if ($serviceRequest->nationality == "BOLIVIANA") {
              $user->country_id = 28;
            }
            if ($serviceRequest->nationality == "COLOMBIANA") {
              $user->country_id = 45;
            }
            if ($serviceRequest->nationality == "CUBANA") {
              $user->country_id = 54;
            }
            if ($serviceRequest->nationality == "ARGENTINA") {
              $user->country_id = 12;
            }
            $user->email = $serviceRequest->email;
            $user->active = 1;
            $user->external = 0;
            $user->save();
          }else{
            $user = User::find($explode_rut[0]);
          }

          //save bank parameters
          if ($serviceRequest->bank_id != null) {
            // $userBankAccount = new UserBankAccount();
            // $userBankAccount->bank_id = $serviceRequest->bank_id;
            // $userBankAccount->user_id = $user->id;
            // $userBankAccount->number = $serviceRequest->account_number;
            // $userBankAccount->type = $serviceRequest->pay_method;
            // $userBankAccount->save();
            $userBankAccount = UserBankAccount::updateOrCreate(
                ['user_id' => $user->id],
                ['bank_id' => $serviceRequest->bank_id,
                 'number' => $serviceRequest->account_number,
                 'type' => $serviceRequest->pay_method]
            );
          }



          // modify service request
          $serviceRequests = ServiceRequest::withTrashed()->where('rut',(int)$explode_rut[0])->get();
          foreach ($serviceRequests as $key => $serviceRequest) {
            $serviceRequest->creator_id = $serviceRequest->user_id;
            $serviceRequest->user_id = $user->id;
            $serviceRequest->save();
          }
        }

        return 0;
    }
}
