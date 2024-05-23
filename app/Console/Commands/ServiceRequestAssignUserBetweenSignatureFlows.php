<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\SignatureFlow;
use App\Models\User;

class ServiceRequestAssignUserBetweenSignatureFlows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sr-request-assignuser-between-signatureflows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_id = 15050378; //usuario objetivo
        $user_change = User::find(18263660); //usuario al cual se agregará entre medio
        // dd($user_change);
        // $data = [];

        $notAvailableCount = 0;
        $pendingCount = 0;
        $signedCount = 0;
        $rejecedCount = 0;

        $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
            $subQuery->whereNull('status')
                    ->where( function($query) use($user_id){
                        $query->where('responsable_id', $user_id)
                                ->orwhere('user_id', $user_id);
                    });
        })
        ->wheredoesnthave("SignatureFlows", function($subQuery) {
            $subQuery->where('status',0);
        })
        // ->where('id',34557)
        ->with('SignatureFlows')
        ->get();

        foreach ($serviceRequests as $key => $serviceRequest) {
            if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0) {
                foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
                    //with responsable_id
                    if ($user_id == $signatureFlow->responsable_id || $user_id == $signatureFlow->user_id) {
                        if ($signatureFlow->status == NULL) {
                            if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()) {
                                if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()->status == NULL) {

                                } 
                                else 
                                {
                                    // if($type == "pending"){
                                    //     $data[$serviceRequest->id] = $serviceRequest;
                                    // }
                                    $pendingCount += 1;
                                }
                            }
                        } 
                    }
                }
            }
        }

        $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
            $subQuery->whereNull('status')
                    ->where( function($query) use($user_id){
                        $query->where('responsable_id', $user_id)
                                ->orwhere('user_id', $user_id);
                    });
        })
        ->wheredoesnthave("SignatureFlows", function($subQuery) {
            $subQuery->where('status',0);
        })
        ->with('SignatureFlows')
        // ->where('id',34557)
        ->get();

        // dd($serviceRequests);
        foreach ($serviceRequests as $key => $serviceRequest) {
            if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0) {
                foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
                    //with responsable_id
                    if ($user_id == $signatureFlow->responsable_id) {
                        if ($signatureFlow->status == NULL) {
                            if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()) {
                                if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()->status == NULL) {
                                    $notAvailableCount += 1;

                                    $flag = 0;
                                    foreach($serviceRequest->SignatureFlows as $signatureFlow){
                                        if($signatureFlow->status == null){
                                            if($signatureFlow->responsable_id == $user_id && $flag == 0 && $signatureFlow->status == null){
                                                // dd($signatureFlow);
                                                $flag = 1;
                                                $clone = $signatureFlow->replicate();
                                                $clone->responsable_id = $user_change->id;
                                                $clone->ou_id = $user_change->organizational_unit_id;
                                                $clone->employee = $user_change->position;
                                                $clone->save();
                                            }
                                            if($flag == 1 && $signatureFlow->status == null){
                                                $signatureFlow->sign_position = $signatureFlow->sign_position + 1;
                                                $signatureFlow->save();
                                            }
                                        }
                                    }
                                } 
                            }
                        } 
                    }
                }
            }
        }

        print_r($notAvailableCount);
        return Command::SUCCESS;
    }
}
